<?php

namespace App\Http\Requests;

use App\Models\User;
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
    return true;
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
    $user = User::find(Auth::user()->id);
    $username = $this->username == $user->username;
    $name = $this->name == $user->name;

    if ($username && $name){
      // back
      // jika sama semua maka return back() tidak ada perubahan
      $this->merge([
        'message' => 'tidak ada perubahan yang diperlukan.',
    ]);
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
