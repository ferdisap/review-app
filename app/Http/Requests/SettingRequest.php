<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;

class SettingRequest extends FormRequest
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
    switch ($this->type_form) {
        case 'change password':
          return $this->changePassword();
          break;
        
        case 'change personal information':
          return $this->changePersonalInformationRules();
          break;
  
        case 'change pprofile':
          return $this->changePProfile();
          break;
  
        default:
          return back()->withInput()->with('fail', 'update fail');
          break;
      }    
  }

  /**
   * message jika tidak ada perubahan pada form
   */
  private function noChangeMessage()
  {
    return  $this->merge([
      'message' => 'Tidak ada perubahan yang diperlukan.'
    ]);
  }

  /**
   * Change Personal Information validation rules
   */
  private function changePersonalInformationRules()
  {
    $user = User::find(Auth::user()->id);
    $username = $this->username == $user->username;
    $name = $this->name == $user->name;

    //jika kedua-duanya sama dengan di DB, maka tidak ada perubahan
    if ($username && $name){
      // back
      // jika sama semua maka return back() tidak ada perubahan
      $this->noChangeMessage();
    }
    // jika username:beda dan nama:sama, validasi username saja
    elseif(!$username && $name){
      $this->rules = [
        'username' => 'min:8|max:12|unique:users,username',
      ];
    } 
    // jika nama:beda dan username:sama, validasi nama saja
    elseif(!$name && $username){
      $this->rules = [
        'name' => 'max:255|unique:users,name',
      ];
    }
    // jika kedua duanya:beda, validasi semuanya
    else {
      $this->rules = [
        'username' => 'min:8|max:12|unique:users,username',
        'name' => 'max:255|unique:users,name',
      ];
    }
  }

  /**
   * Change pprofile validation rules
   */
  private function changePProfile()
  {
    if (!$this->file('pprofile')){
      $this->noChangeMessage();
    }
    else {
      $this->rules = [
        'pprofile' => 'required|mimes:jpeg, bmp, png, gif',
      ];
    }
  }

  /**
   * Change password validation rules
   */
  private function changePassword()
  {
    // dd($this->oldPassword == null && $this->newPassword == null);
    if ($this->oldPassword == null && $this->newPassword == null){
      $this->noChangeMessage();
    }
    else{
      $this->rules = [
        'oldPassword' =>['required', function ($attribute, $value, $fail){
            if(!Hash::check($value, Auth::user()->password)){
              return $fail(__('The current password is incorrect.'));
            }
        }],
        'newPassword' => ['required', 'confirmed', Rules\Password::defaults()],
      ];
    }

  }
}
