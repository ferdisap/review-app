<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;


use Fimage\Resizer;
use Fimage\Formatter;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

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
  public function update(SettingRequest $request){
    // type hint param harus insstance of SettingRequest form validation dimana didalamnya akan menyeleksi form pprofile, change password atau lainnya
    
    if ($request->message){
      return $this->back(false, $request->message);
    }
    // action tobe updated
    switch ($request->type_form){
      case 'change password' :
        return $this->updatePassword($request) ? $this->back(true, 'update success', ['open_form1' => true]) : $this->back(false, 'update fail', ['open_form1'  => true]);
        break;
      case "change personal information":
        return $this->updatePersonalInformation($request) ? $this->back(true, 'update success') : $this->back(false, 'update fail');
        break;
      case 'change pprofile':
        return $this->updatePProfile($request) ? $this->back(true, 'update success') : $this->back(false, 'update fail');
        break;
      default:
        return $this->back(false, 'update fail');
        break;
    }    
  }

  /**
   * Method untuk update setting/change User password
   */
  private function updatePassword($request){
    $status = User::whereId(Auth::user()->id)->update([
      'password' => Hash::make($request->newPassword),
    ]);
    return $status ? true : false;
  }

  /**
   * Method untuk update setting/change Photo Profile
   */
  private function updatePProfile($request){
    $path = $request->file('pprofile')->path();
    $storePath = storage_path() . "\app\photos\pprofile\\" . Auth::user()->username . '.jpg';
    $formatter = Formatter::reformat('jpg', $path, $storePath);
    $resizer = Resizer::resizeToWidth($storePath, 400);
    if (!($formatter || $resizer)){
      return abort(500);
    }
    return true;
    // $this->resizeImage($path, 100);
    // if ($path = $request->pprofile->storeAs('photos', "pprofile/" . Auth::user()->username . "." . $request->pprofile->extension()) ){
    //   if (User::where('username', '=', Auth::user()->username)->update(['pprofile' => $path])){
    //     return true;      
    //   } 
    // } 
    // return false;
  }

  /**
   * Method untuk update setting/change Personal Information
   */
  private function updatePersonalInformation($request){
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
  // public function resizeImage(String $path = null, Int $width){
  //   if ($path){
  //     $image = new ImageResize($path);
  //     $image->resizeToWidth($width);
  //     $image->save($path);
  //   }
  // }

  /**
   * back with session
   */
  private function back(bool $failOrSuccess, string $message, array $withInput = null){
    if ($failOrSuccess){
      return back()->withInput($withInput)->with('success', $message);
    }
    return back()->withInput($withInput)->with('fail', $message);
  }

  /**
   * set personal token
   */
  public function setToken(Request $request){
    // return 'fail';
    $uuid = Str::uuid();
    if (User::where('personal_token', '=', $request->old_personal_token)->update(['personal_token' => $uuid]) == 1){
      return $uuid;
    }
    return 'fail';

  }

  /**
   * $filename adalah $path to image, not relative page
   * TIDAK DIPAKAI
   */
  // public function resizeImage2($filename){
  //   $filename = $filename;
      
  //   // Maximum width and height
  //   $width = 100;
  //   $height = 100;
      
  //   // File type
  //   header('Content-Type: image/jpg');
      
  //   // Get new dimensions
  //   list($width_orig, $height_orig) = getimagesize($filename);
      
  //   $ratio_orig = $width_orig/$height_orig;
      
  //   if ($width/$height > $ratio_orig) {
  //       $width = $height*$ratio_orig;
  //   } else {
  //       $height = $width/$ratio_orig;
  //   }
      
  //   // Resampling the image 
  //   $image_p = imagecreatetruecolor($width, $height);
  //   $image = imagecreatefromjpeg($filename);
      
  //   imagecopyresampled($image_p, $image, 0, 0, 0, 0,
  //           $width, $height, $width_orig, $height_orig);
      
  //   // Display of output image
  //   return imagejpeg($image_p, null, 100);
  // }
}
