<?php

namespace App\Http\Controllers;

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
    // Validation request
    switch ($request->type_form) {
      case 'change password':
        $request->validate([
          'old_password' =>'required',
          'new_password' => ['required', 'confirmed', Rules\Password::defaults()],
          // 'confirm_password' => '',
        ]);
        break;
      
      case 'change personal information':
        $request->validate([
          'username' => $request->username ? 'min:8|max:12' : null,
          'name' => $request->username ? 'max:255' : null,
          'email' => $request->email ? ['string', 'email', 'max:255', 'unique:'.User::class]  : null,
        ]);
        break;

      case 'change pprofile':
        $request->validate([
          'pprofile' => 'required|mimes:jpeg, bmp, png, gif',
        ]);
        break;

      default:
        return back()->withInput()->with('fail', 'update fail');
        break;
    }

    // action tobe updated
    $result = false;
    switch ($request->type_form){
      case 'change passwird' :
      case 'change personal information':
      case 'change pprofile':
        $result = $this->updatePProfile($request) ? true : false;
      default:
        return $result ? 
        back()->withInput()->with('success', 'foobar') :
        back()->withInput()->with('fail', 'update fail');
        break;
    }    
  }

  /**
   * Method untuk update setting/chagnge Photo Profile
   */
  private function updatePProfile(Request $request){
    // try {
    //   $path = $request->file('pprofile')->path();
    //   $this->resizeImage($path, 100);
    //   $request->pprofile->storeAs('public/photos/pprofile', Auth::user()->username . "." . $request->pprofile->extension());
    //   return true;
    // } catch (\Throwable $e) {
    //   return false;
    // }
    $path = $request->file('pprofile')->path();
    $this->resizeImage($path, 100);
    if ($path = $request->pprofile->storeAs('public/photos/pprofile', Auth::user()->username . "." . $request->pprofile->extension()) ){
      User::where('username', '=', Auth::user()->username)->update([
        'pprofile' => $path
      ]);
      return true;      
    } else{
      return false;
    } 
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
