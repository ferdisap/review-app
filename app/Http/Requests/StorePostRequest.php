<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\MaxWord;
use Gumlet\ImageResize;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;

class StorePostRequest extends FormRequest
{
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
      'id' => 'required',
      'title' => ['max:30'],
      'images.*' => ['mimes:jpeg, bmp, png, gif'],
      'images' => ['array', function($attribute, $value, $fail){
        foreach ($this->images as $key => $image){
          $path = $image->path();
          if ( ($result = $this->resizeImage($path, 50)) == 'true' ){
            $path = $image->storeAs('postImages', Auth::user()->username . "/thumbnail/" . '/' . $this->id . '_50_' . $key . '.' . $image->extension());
          } elseif ($result == false){
            $fail('An error occured on '.$attribute.' of ' . $key+1  . ',  no path provided.');
          } elseif (gettype($result) == 'string'){
            $fail('An error occured on '.$attribute.' of ' . $key+1 .', ' . $result);
          }
        }
      }],
      'simpleDescription' => [new MaxWord(100)],
      'detailDescription' => ['required', new MaxWord(1000)],
    ];
  }

  /**
   * Prepare the data before validation
   */
  protected function prepareForValidation()
  {
    // dd($this);
    // $this->old('simpleDescription', 'foo');
    // session()->put('tilte', 'foo');
    // if ($this->file('images')) {
      // foreach ($this->file('images') as $key => $image) {
      //   $path = $image->path();
      //   $this->resizeImage($path, 50);
      //   $path = $image->storeAs('postImages', Auth::user()->username . "/thumbnail/" . '/' . $this->id . '_50_' . $key . '.' . $image->extension());
      // }
    // }
  }

  /**
   * @integer $width adalah PX
   * @return true if the resize is done
   * @return false if no path provided
   * @return string if the error gotten
   */
  private function resizeImage(String $path = null, Int $width)
  {
    if ($path) {
      try {
        $image = new ImageResize($path);
        $image->resizeToWidth($width);
        $image->save($path);
        return true;
      } catch (\Throwable $e) {
        return (string) $e->getMessage();
      }
    }
    return false;
  }
}
