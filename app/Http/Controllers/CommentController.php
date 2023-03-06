<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Rules\MaxWord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
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
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Post  $post
   * @return \Illuminate\Http\Response
   */
  public function store(Post $post, Request $request)
  {
    $validator = Validator::make($request->all(), [
      'comment' => ['required', new MaxWord(100)]
    ]);

    if ($validator->fails()) {
      return back()->withErrors($validator)->withInput([
        'open_comment_form' => $request->open_comment_form,
        'open_add_comment_form' => $request->open_add_comment_form,
        ])->with('fail', 'fail to send comment.');
    }

    Comment::create([
      'description' => $request->comment,
      'commentator_id' => Auth::user()->id,
      'post_uuid' => $post->uuid,
    ]);
    
    return back()->withInput(['open_comment_form' => $request->open_comment_form])->with('success', 'comment has been added.');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Comment  $comment
   * @return \Illuminate\Http\Response
   */
  public function show(Comment $comment)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Comment  $comment
   * @return \Illuminate\Http\Response
   */
  public function edit(Comment $comment)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Comment  $comment
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Comment $comment)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Comment  $comment
   * @return \Illuminate\Http\Response
   */
  public function destroy(Comment $comment)
  {
    //
  }
}
