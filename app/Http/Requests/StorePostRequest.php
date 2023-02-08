<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\MaxWord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StorePostRequest extends FormRequest
{
  public $title_rules;
  public $eachImage_rules = ['mimes:jpg, bmp, png, gif'];
  public $simpleDescription_rules;
  // public $simpleDescription_rules = [new MaxWord(100)];
  public $detailDescription_rules;
  // public $detailDescription_rules = [new MaxWord(100)];
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, mixed>
   */
  public function rules()
  {
    return [
      'uuid' => 'required',
      'title' => $this->title_rules,
      'images.*' => $this->eachImage_rules,
      'images' => ['array', function ($attribute, $value, $fail) {
        foreach ($this->images as $key => $image) {
          $path_w50 = $image->storeAs('postImages', Auth::user()->username . "/thumbnail" . '/' . $this->uuid . '_50_' . $key . '.' . $image->extension());
          $path_w400 = $image->storeAs('postImages', Auth::user()->username . "/display" . '/' . $this->uuid . '_400_' . $key . '.' . $image->extension());

          $resized_w50 = $this->resizeImage($path_w50, 50);
          $resized_w400 = $this->resizeImage($path_w400, 400);
          
          // jika (!T||!T) == F
          if (!$resized_w50 || !$resized_w400){
            dd('tesg');
            Storage::delete([$path_w50, $path_w400]);
            $fail(ucfirst($attribute) . ' of ' . $key+1 . ' has problem. Error:01');
          }
        }
      }],
      'simpleDescription' => $this->simpleDescription_rules,
      'detailDescription' => $this->detailDescription_rules,
    ];
  }

  /**
   * Prepare the data before validation
   */
  protected function prepareForValidation()
  {
    if ($this->submit === 'publish') {
      $this->title_rules = ['required', 'max:30'];
      $this->simpleDescription_rules = ['required', new MaxWord(100)];
      $this->detailDescription_rules = ['required', new MaxWord(100)];
      $this->merge([
        'isDraft' => 0,
        'author' => Auth::user()->id,
      ]);
    } else {
      $this->title_rules = ['max:30'];
      $this->simpleDescription_rules = [new MaxWord(100)];
      $this->detailDescription_rules = [new MaxWord(100)];
      $this->merge([
        'isDraft' => 1,
        'author' => Auth::user()->id,
      ]);
    }
  }

  // /**
  //  * @integer $width adalah PX
  //  * @return true if the resize is done
  //  * @return false if no path provided
  //  * @return string if the error gotten
  //  */
  // private function resizeImage(String $path = null, Int $width)
  // {
  //   if ($path) {
  //     try {
  //       $image = new ImageResize($path);
  //       $image->resizeToWidth($width);
  //       $image->save($path);
  //       return true;
  //     } catch (\Throwable $e) {
  //       return (string) $e->getMessage();
  //     }
  //   }
  //   return false;
  // }

  /**
   * (int) $height = 0 berarti resizeToWidth
   */
  function resizeImage($imagePath, $width, $height = 0, $filterType = \Imagick::FILTER_LANCZOS, $blur = 1, $bestFit = false , $cropZoom = false)
  {
    // $imagick = new \Imagick(realpath($imagePath));
    $imagick = new \Imagick($imagePath);

    $cropWidth = $imagick->getImageWidth();
    $cropHeight = $imagick->getImageHeight();

    if ($height == 0){
      $ratio  = $width / $cropWidth;
      $height = (int) ($cropHeight * $ratio);
    }

    $imagick->resizeImage($width, $height, $filterType, $blur, $bestFit);

    if ($cropZoom) {
      $newWidth = $cropWidth / 2;
      $newHeight = $cropHeight / 2;

      $imagick->cropimage(
        $newWidth,
        $newHeight,
        ($cropWidth - $newWidth) / 2,
        ($cropHeight - $newHeight) / 2
      );

      $imagick->scaleimage(
        $imagick->getImageWidth() * 4,
        $imagick->getImageHeight() * 4
      );
    }
    $path_wo_ext = preg_replace('/\.\w+$/m', '' ,$imagePath);
    dd($imagick->getImageFormat());

    if($imagick->getImageFormat() == 'JPEG' || $imagick->getImageFormat() == 'JPG'){
      return false;
    }
    $imagick->setImageFormat('jpg');
    if ($imagick->writeImageFile(fopen ($path_wo_ext . '.jpg', "wb"))){
      Storage::delete([$imagePath]);
      return true;
    } else {
      // dd('foo');
      return false;
    }
    
  }
}
