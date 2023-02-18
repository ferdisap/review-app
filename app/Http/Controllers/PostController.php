<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
    return view('components.post.index', [
      'posts' => Post::where('isDraft', '=', 1)->where('author', '=', Auth::user()->id)->orderBy('updated_at', 'desc')->get(),
    ]);
  }


  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('components.post.create',[
      'uuid' => old('uuid') ?? 
                (Post::create([
                  'isDraft' => 1,
                  'author' => Auth::user()->id,
                ]))->uuid,
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
    if ($post = Post::find($request->uuid) ){
      $post->title = $request->title;
      $post->simpleDescription = $request->simpleDescription;
      $post->detailDescription = $request->detailDescription;
      $post->isDraft = $request->isDraft;
      $post->author = $request->author;
      $post->save(); 
      return $request->isDraft == true ? 
          back()->withInput()->with('success', 'This Post has been saved.') :
          redirect()->route('mypostindex')->with('success', 'New Post has been published.');
    }

    return back()->withInput()->with('fail', 'No post needed to action.');
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
    dd($id);
  }
  
  /**
   * Receives the posts which want to @destroy from DB
   */
  public function delete(Request $request)
  {
    dd('delete');
    dd($request);
  }
}
