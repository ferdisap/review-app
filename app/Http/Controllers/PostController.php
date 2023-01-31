<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Gumlet\ImageResize;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    //
  }

  /**
   * Display a listring of authenticate person post.
   * 
   * @return \Illuminate\Http\Response
   */
  public function myindex()
  {
    return view('components.post.index');
  }


  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    // $post = Post::create([
    //     'isDraft' => 1,
    //     'author' => Auth::user()->id,
    // ]);
    $post = Post::find('846f12f5-7f42-465d-95b2-88c91cc7a0f9');
    return view('components.post.create',[
      'uuid' => $post->id,
    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(StorePostRequest $request)
  {
    dd($request);
    // foreach ($request->file('images') as $key => $image) {
    //   $path = $image->path();
    //   $this->resizeImage($path, 50);
    //   $image->storeAs('postImages', "thumbnail/" . 'PostTitle1' . '_50_' . $key . '.' . $image->extension());
    // }
    // dd($request->file('images')[0]->path());
    // dd($request->file('postImage'));
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    dd('show');
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
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
}