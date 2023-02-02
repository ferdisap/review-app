<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\MaxWord;
use Gumlet\ImageResize;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;

class StorePostRequest extends FormRequest
{
  public $title_rules;
  public $eachImage_rules = ['mimes:jpeg, bmp, png, gif'];
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
      'id' => 'required',
      'title' => $this->title_rules,
      'images.*' => $this->eachImage_rules,
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
      'simpleDescription' => $this->simpleDescription_rules,
      'detailDescription' => $this->detailDescription_rules,
    ];
  }

  /**
   * Prepare the data before validation
   */
  protected function prepareForValidation()
  {
    if ($this->submit === 'publish'){
      $this->title_rules = ['required', 'max:30'];
      $this->simpleDescription_rules = ['required', new MaxWord(100)];
      $this->detailDescription_rules = ['required', new MaxWord(100)];
      $this->merge([
        'isDraft' => 0,
      ]);
    }
    else {
      $this->title_rules = ['max:30'];
      $this->simpleDescription_rules = [new MaxWord(100)];
      $this->detailDescription_rules = [new MaxWord(100)];
      $this->merge([
        'isDraft' => 1
      ]);
    }
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
