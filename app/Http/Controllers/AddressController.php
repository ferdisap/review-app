<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
  /**
   * before starting to fill the Indexes, adjust the RouteServiceProvider rate limiting for example 360 seconds or more; 
   */
  public function fillIndexes()
  {
    // dd(Address::count());
    $alphabets = str_split('abcdefghijklmnopqrstuvwxyz');

    foreach ($alphabets as $key => $letter) {
      $json =  file_get_contents(storage_path('/dataalamatindonesia/input=' . $letter . '&limit=10000.json'));
      $addresses = json_decode($json, true)['data']['suggestions'];
      // dd($array);
      foreach ($addresses as $key => $address) {
        Address::findOr($address['id'], function () use ($address) {
          Address::create([
            'id' => $address['id'],
            'name' => $address['name'],
            'type' => $address['type'],
            'latitude' => (string) $address['latitude'],
            'longitude' => (string) $address['longitude'],
            'parentId' => $address['parentId'] ?? null,
          ]);
        });
      }
    }
    return 'success, try to check the db';
  }

  /**
   * to search the address by the request parameter
   */
  public function search(Request $request, $limit = 5)
  {
    if ($name = $request->name) {
      $addresses = Address::where('name', 'like', '%' . $name . '%')->orderBy('name', 'asc')->limit($limit)->get();
      return response()->json([
        'status' => 200,
        'addresses' => $addresses
      ]);
    }
    return response()->json([
      'status' => 400,
      'addresses' => null,
    ]);
  }

  /**
   * to push the address for each user
   */
  public function push(Request $request)
  {
    $name = $request->name;
    $name = Address::where('name', '=', $name)->get(['id']);
    if (count($name) > 0) {
      $user = User::withoutGlobalScope('defaultColumnSelected')->select(['id', 'geo_loc'])->find(Auth::user()->id);
      $user->geo_loc = $name[0]['id'];
      if ($user->save()) {
        $status = 200;
      }
    } else {
      $status = 400;
    }
    return response()->json([
      'success' => $status
    ]);
  }

  /**
   * to pull the address such as name/latitude/longitude by the request query
   */
  public function pull(Request $request)
  {
    if ($username = $request->username) {
      $user_geo_loc = User::withoutGlobalScope('defaultColumnSelected')->select(['geo_loc'])->where('username', '=', $username)->get()[0]->geo_loc;
      $address = $this->renderAddressComponent(Address::select(['id', 'parentId', 'name'])->find($user_geo_loc));
      return response()->json([
        'status' => 200,
        'address' => $address
      ]);
    }
    return response()->json([
      'status' => 400,
      'address' => null,
    ]);
  }

  private function renderAddressComponent(Address $address)
  {
    $str = $address->name;
    if ($address->parent){
      $str = $str . ', '. $address->parent->name;
      if ($address->parent->parent){
        $str = $str . ', '. $address->parent->parent->name;
        if ($address->parent->parent->parent){
          $str = $str . ', '. $address->parent->parent->parent->name;
        }
      }
    }
    return $str;
  }
}
