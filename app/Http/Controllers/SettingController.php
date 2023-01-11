<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePersonalInformationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

use Gumlet\ImageResize;

class SettingController extends Controller
{
  public function index($setting = null){

    switch ($setting) {
      case 'account':
        return view('components.setting.account');
        break;
      
      default:
        return view('components.setting.index');
        break;
    }
  }

  /**
   * Untuk mengupdate data account user
   */
  public function update(Request $request){
    // type hint param harus insstance of SettingRequest form validation dimana didalamnya akan menyeleksi form pprofile, change password atau lainnya
    
    // Validation request
    // switch ($request->type_form) {
    //   case 'change password':
    //     $request->validate([
    //       'old_password' =>'required',
    //       'new_password' => ['required', 'confirmed', Rules\Password::defaults()],
    //       // 'confirm_password' => '',
    //     ]);
    //     break;
      
    //   case 'change personal information':
    //     $request->validate([
    //       'username' => $request->username ? 'min:8|max:12|unique:users,username' : null,
    //       'name' => $request->name ? 'max:255|unique:users,name' : null,
    //       // 'email' => $request->email ? ['string', 'email', 'max:255', 'unique:'.User::class]  : null,
    //     ]);
    //     break;

    //   case 'change pprofile':
    //     $request->validate([
    //       'pprofile' => 'required|mimes:jpeg, bmp, png, gif',
    //     ]);
    //     break;

    //   default:
    //     return back()->withInput()->with('fail', 'update fail');
    //     break;
    // }
    if ($request->message){
      return $this->back(false, $request->message);
    }
    // action tobe updated
    switch ($request->type_form){
      case 'change password' :
      case "change personal information":
        $form = ChangePersonalInformationRequest::createFrom($request);
        dd($form);
        // return $this->updatePersonalInformation($form) ? $this->back(true, 'update success') : $this->back(false, 'update fail');
        break;
      case 'change pprofile':
        // return $this->updatePProfile($request) ? $success : $fail;
        return $this->updatePProfile($request) ? $this->back(true, 'update success') : $this->back(false, 'update fail');
        break;
      default:
        return $this->back(false, 'update fail');
        break;
    }    
  }

  /**
   * Method untuk update setting/chagnge Photo Profile
   */
  private function updatePProfile(Request $request){
    $path = $request->file('pprofile')->path();
    $this->resizeImage($path, 100);
    if ($path = $request->pprofile->storeAs('photos', "pprofile/" . Auth::user()->username . "." . $request->pprofile->extension()) ){
      if (User::where('username', '=', Auth::user()->username)->update(['pprofile' => $path])){
        return true;      
      } 
    } 
    return false;
  }

  /**
   * Method untuk update setting/change Personal Information
   */
  private function updatePersonalInformation(ChangePersonalInformationRequest $request){
    // $request->validateResolved();
    // if($request->authorize()){
    //   $request = $request->prepareForValidation();
    //   $request = $request->rules();
    // }
    if (User::find(Auth::user()->id)->update([
      'username' => $request->username,
      'name' => $request->name,
    ]) ){
      return true;
    }
    return false;
  }

  /**
   * @integer $width adalah PX
   */  
  public function resizeImage(String $path = null, Int $width){
    if ($path){
      $image = new ImageResize($path);
      $image->resizeToWidth($width);
      $image->save($path);
    }
  }

  /**
   * back with session
   */
  private function back(bool $failOrSuccess, string $message){
    if ($failOrSuccess){
      return back()->withInput()->with('success', $message);
    }
    return back()->withInput()->with('fail', $message);
  }

  /**
   * $filename adalah $path to image, not relative page
   * TIDAK DIPAKAI
   */
  public function resizeImage2($filename){
    $filename = $filename;
      
    // Maximum width and height
    $width = 100;
    $height = 100;
      
    // File type
    header('Content-Type: image/jpg');
      
    // Get new dimensions
    list($width_orig, $height_orig) = getimagesize($filename);
      
    $ratio_orig = $width_orig/$height_orig;
      
    if ($width/$height > $ratio_orig) {
        $width = $height*$ratio_orig;
    } else {
        $height = $width/$ratio_orig;
    }
      
    // Resampling the image 
    $image_p = imagecreatetruecolor($width, $height);
    $image = imagecreatefromjpeg($filename);
      
    imagecopyresampled($image_p, $image, 0, 0, 0, 0,
            $width, $height, $width_orig, $height_orig);
      
    // Display of output image
    return imagejpeg($image_p, null, 100);
  }
}
