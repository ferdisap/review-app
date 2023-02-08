<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\MaxWord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\MessageBag;

class StorePostRequest extends FormRequest
{
  public $title_rules;
  // public $eachImage_rules = ['mimes:jpg, bmp, png, gif', 'file', 'bail' ,'max:128'];
  public $eachImage_rules = 'mimes:jpg, bmp, png, gif|file|max:128';
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
      'images' => ['required','array', function ($attribute, $value, $fail) {
        foreach ($this->images as $key => $image) {

          // selanjutnya, jika validation 'images.* fail, maka jangan lakukan validasi ini (jangan menyimpan file)
          dd($this->errorBag('default'));
          dd($this);
          if ($image->isValid()){
            $path = storage_path() . "\app\postImages\\ferdisap\\thumbnail\\" . $this->uuid . '_50_' . $key . '.' . 'jpg';
            $this->setFormatImg($image->path(), $path);
            $this->resizeImage($path, 50);
          } else {
            $fail('The ' . $attribute . '.' . $key . ' is invalid file.');
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

  /**
   * @return true if success, otherwise false
   */
  function resizeImage($imagePath, $width, $imageFormat = 'jpg', $filterType = \Imagick::FILTER_LANCZOS, $blur = 1, $bestFit = false)
  {
    $im = new \Imagick($imagePath);
    $height = (int) ($im->getImageHeight() * ($width /  $im->getImageWidth()));
    $im->resizeImage($width, $height, $filterType, $blur, $bestFit);
    return $im->writeImage($imagePath) ?? false;
  }

  /**
   * @return true on success, otherwise false
   */
  function setFormatImg($imagePath, $storePath)
  {
    $im = new \Imagick($imagePath);
    // if ($im->getImageFormat() == 'JPEG' || $im->getImageFormat() == 'JPG') {
    //   return false;
    // }
    try {
      $im->setImageFormat('jpg');
      $im->writeImageFile(fopen($storePath, "wb"));
      return true;
    } catch (\Throwable $e) {
      return false;
    }
  }
}
