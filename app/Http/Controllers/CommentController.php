<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Rules\MaxWord;
use Illuminate\Contracts\View\View;
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
      return back()->withErrors($validator)->withInput()->with('fail', 'fail to send comment.');
    }

    Comment::create([
      'description' => $request->comment,
      'commentator_id' => Auth::user()->id,
      'post_uuid' => $post->uuid,
    ]);
    
    return back()->withInput()->with('success', 'comment has been added.');
    // return back()->withInput(['open_comment_form' => $request->open_comment_form])->with('success', 'comment has been added.');
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
  public function destroy(Comment $comment, Request $request)
  {
    return back()->withInput()->with('success', 'This come from destroy()');
  }

  /**
   * more comment
   */
  public function more_comment(Request $request)
  {
    // dd($request);
    $comments = Comment::where('post_uuid', '=', $request->post_uuid)->withoutGlobalScope('limitQuery')->offset($request->offset)->limit($request->limit)->get();
    // $comments = Comment::where('post_uuid', '=', $request->post_uuid)->withoutGlobalScope('limitQuery')->offset(2)->paginate($request->qty);
    // dd(Auth::user());
    $comments->each(function ($comment,$key){
      if (Auth::user()){
        Auth::user()->id == $comment->commentator->id ? $comment->isMine($comment, true) : $comment->isMine($comment, false);
      } else {
        $comment->isMine($comment, false);
      }
      $comment->makeHidden(['commentator_id']);
      $comment->timeForHumans($comment);
      $comment->commentator->setHidden(['id', 'password', 'remember_token', 'email']);
    });
    
    return response()->json([
      'status' => 200,
      'comments' => $comments,
    ]);
  }

  /**
   * load view for comment form / more comment
   */
  public function load_view()
  {
    // return response()->json(['status' => 200, 'view' => 'foo']);
    $view = view('components.comment',[
      'isCommenting' => false,
      'ajax' => true
    ])->render();
    return response()->json(['status' => 200, 'view' => $view]);
  }

}
