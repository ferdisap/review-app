<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\MaxWord;
use Fimage\ImageResizer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use Fimage\Resizer;
use Fimage\Formatter;

class StorePostRequest extends FormRequest
{
  public $title_rules;
  public $simpleDescription_rules;
  public $detailDescription_rules;
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
      'images.*' => ['mimes:jpg,png', 'max:4048', function ($attribute, $image, $fail) {

        if ($this->validator->errors()->get($attribute) == []) {
          $storePath = storage_path() . "\app\postImages\\ferdisap\\thumbnail\\" . $this->uuid . '_50_' . $attribute . '.' . 'jpg';
          Formatter::reformat('jpg', $image->path(), $storePath);
          Resizer::resizeToWidth($storePath, 50);
          
          $storePath = storage_path() . "\app\postImages\\ferdisap\\display\\" . $this->uuid . '_400_' . $attribute . '.' . 'jpg';
          Formatter::reformat('jpg', $image->path(), $storePath);
          Resizer::resizeToWidth($storePath, 400);
        }
      }],
      'simpleDescription' => $this->simpleDescription_rules,
      'detailDescription' => $this->detailDescription_rules,
      'category' => 'exists:categories,name',
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
      $this->detailDescription_rules = ['required', new MaxWord(500)];
      $this->merge([
        'isDraft' => 0,
        'author_id' => Auth::user()->id,
        'category' => $this->category
      ]);
    } else {
      $this->title_rules = ['max:30'];
      $this->simpleDescription_rules = [new MaxWord(100)];
      $this->detailDescription_rules = [new MaxWord(500)];
      $this->merge([
        'isDraft' => 1,
        'author_id' => Auth::user()->id,
        'category' => $this->category
      ]);
    }
  }

}
