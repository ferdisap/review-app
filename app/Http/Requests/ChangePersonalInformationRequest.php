<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ChangePersonalInformationRequest extends FormRequest
{
  // private $validationElement = [
  //   'username' => 'min:8|max:12|unique:users,username',
  //   'name' => 'max:255|unique:users,name',
  // ];
  private $rules = [];

  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return false;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, mixed>
   */
  public function rules()
  {
    return $this->rules;
  }

  /**
   * Prepare the data for validation.
   *
   * @return void
   */
  protected function prepareForValidation()
  {
    $username = $this->username;
    $name = $this->name;

    if ($username == Auth::user()->username && $name == Auth::user()->name){
      // back
      // jika sama semua maka return back() tidak ada perubahan
    } elseif($username){
      $this->rules = [
        'username' => 'min:8|max:12|unique:users,username',
      ];
    } elseif($name){
      $this->rules = [
        'name' => 'max:255|unique:users,name',
      ];
    } else {
      $this->rules = [
        'username' => 'min:8|max:12|unique:users,username',
        'name' => 'max:255|unique:users,name',
      ];
    }
  }
}
