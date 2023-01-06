<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

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

    dd($request->pprofile);
    dd($request->file('pprofile'));

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
          'pprofile' => 'mimes:jpeg, bmp, png, gif',
        ]);
        break;

      default:
        return back()->withInput()->with('fail', 'update fail');
        break;
    }

    $request->pprofile->storeAs('images', Auth::user()->username . $request->pprofile->extension());

    return back()->withInput()->with('success', 'foobar');
    
    
    return response()->json([
      'result' => 'success'
    ]);
  }
}
