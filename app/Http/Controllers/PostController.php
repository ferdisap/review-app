<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Jobs\ProccessRating;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Rules\MaxWord;
use Illuminate\Bus\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
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
    $postsDraft = Post::where('isDraft', '=', 1)->where('author_id', '=', Auth::user()->id)->orderBy('updated_at', 'desc')->paginate(9, ['*'], 'draft')->withQueryString()->onEachSide(2);
    $postsPublished = Post::where('isDraft', '=', 0)->where('author_id', '=', Auth::user()->id)->orderBy('updated_at', 'desc')->paginate(9, ['*'], 'published')->withQueryString()->onEachSide(2);

    return view('components.post.index', [
      'active' => request()->active ?? null,
      'postsDraft' => $postsDraft,
      'postsPublished' => $postsPublished,
    ]);
  }


  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request = null)
  {
    $uuid = $request->uuid ?? null;
    if (old('uuid')) {
      $post = Post::with('category')->find(old('uuid'));
    } elseif ($uuid) {
      $post = Post::with('category')->find($uuid);
    } 
    else {
      $post = Post::create([
        'category_id' => 1,
        'isDraft' => 1,
        'author_id' => Auth::user()->id,
        'token' => Str::ulid(),
      ]);
    }
    $post->category_name($post, $post->category->name);

    return view('components.post.create',[
      'post' => $post,
      'being_edit' => $post->being_edit,
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
    if ($post = Post::find($request->uuid)) {
      $post->title = $request->title;
      $post->simpleDescription = $request->simpleDescription;
      $post->detailDescription = $request->detailDescription;
      $post->isDraft = $request->isDraft;
      $post->author_id = $request->author_id;
      $post->category_id = $request->category_id;
      $post->save();

      
      $status = 'success';
      if ($request->being_edit == true){
        $message = $post->title . ' has been saved.';  
        // return back()->withInput()->with($status, $message);
        
        return redirect($request->root() .'/post/show/' . $request->uuid)->with($status, $message);

      } elseif ($request->isDraft == true) {   
        $message = 'This Post has been saved.';  
        return redirect()->route('mypostindex')->with($status, $message);
      } else {
        $message = 'New Post has been published.';
        return redirect()->route('mypostindex')->with($status, $message);
      }        
    }
    return back()->withInput()->with('fail', 'No post needed to action.');
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($uuid)
  {
    if (Auth::user() != null) {
      $otherPost = Post::where('author_id', '=', Auth::user()->id)->where('isDraft', '=', 0)->orderBy('updated_at', 'desc')->limit(3)->get();
    }
    $post = Post::select(['uuid', 'title', 'simpleDescription', 'author_id', 'ratingValue'])->with(['author', 'comments'])->findOrFail($uuid);
    return view('components.post.show', [
      'post' => $post,
      'ratingValue' => $post->ratingValue,
      'otherPosts' => $otherPost ?? null,
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id, Request $request)
  { 
    $request->merge(['being_edit' => true, 'uuid' => $id]);
    return $this->create($request);
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
    $result = Post::find($id)->delete();
    if (!$result) {
      return false;
    }
    return true;
  }

  /**
   * Receives the posts which want to @destroy from DB
   */
  public function delete(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'list-post-cb' => ['required'],
    ]);

    // jika user cuma mencet delete post btn tanpa nyontreng, delete post is failed
    if ($validator->fails()) {
      return back()->withInput()->with('fail', 'delete post(s) failed.');
    }

    // proses mendelete post. Jika gagal, maka akan di tambahkan ke failedDestroyedUUID dan dilabelin 'checked' supaya di UI nya di otomatis di contreng
    $failedDestroyedUUID = [];
    foreach ($validator->getData()['list-post-cb'] as $uuid) {
      if (!$this->destroy($uuid)) {
        $failedDestroyedUUID[$uuid] = 'checked';
      };
    }

    // jika ada post yang gagal di hapus, maka tambahkan old input ('toogle-switch') kalo ga 'on'/'some'. Jika on artinya checkall. jika some artinya ga semua di checkall (tapi ada yang di check)
    // if validator success, $request->merge['toogle-switch'] => $request->['toogle-switch'] ?? 'some'    
    // di app.js @initialization nya jika 'toogle-switch' checked == true,  maka di toogle(true), jika false, null
    // di toogle slider htmlnya, jika checkedValue nya == 'some', jalankan @showCkBox(), jika == true, maka checked saja (tidak perlu di toogle karena sudah dilakukan oleh @initialization)
    if (($qtyFailed = count($failedDestroyedUUID)) != 0) {
      $failedDestroyedUUID['toogle-switch'] = $request['toogle-switch'] ?? 'some';
      return back()->withInput($failedDestroyedUUID)->with('fail', $qtyFailed . ' post(s) failed to delete.');
    }

    // jika semua post berhasil di destroy dary DB, maka:
    return back()->withInput()->with('success', 'The selected post(s) has been deleted.');
  }

  /**
   * 
   */
  public function search(Request $request)
  {
    if ($request->key == '' || $request->key == null) {
      $posts = [];
    } else {
      $posts = Post::search($request->key)->orderBy('updated_at', 'desc')->limit(4)->get(['uuid', 'title', 'simpleDescription', 'detailDescription', 'isDraft','ratingValue']);
    }
    return response()->json([
      'posts' => $posts,
    ]);
  }

  /**
   * to set Rating Value of the post
   */
  public function setRatingValue(Request $request)
  {
    $postFromDB = Post::find($request->postID);
    if ($postFromDB == null) {
      return response()->json([
        'status' => false,
        'message' => 'no post to be rated.',
        'postRate' => $postFromDB->ratingValue ?? 0,
      ]);
    } elseif (Auth::user() == null || $postFromDB->author_id != Auth::user()->id) {
      $postFromDB->ratingValue = ((($postFromDB->ratingValue ?? 0) / 20) + $request->rateValue) * 20 / ($postFromDB->ratingValue == null ? 1 : 2);
      $postFromDB->save();
      return response()->json([
        'status' => true,
        'message' => 'this post has been added a rate.',
        'postRate' => $postFromDB->ratingValue ?? 0,
      ]);
    } elseif ($postFromDB->author_id == Auth::user()->id) {
      return response()->json([
        'status' => false,
        'message' => 'the author cannot rate their own post.',
        'postRate' => $postFromDB->ratingValue ?? 0,
      ]);
    } else {
      return response()->json([
        'status' => false,
        'message' => 'this post has been failed to rate.',
        'postRate' => $postFromDB->ratingValue ?? 0,
      ]);
    }
    return response()->json([
      'status' => false,
      'message' => 'failed to rate a post.',
      'postRate' => $postFromDB->ratingValue ?? 0,
    ]);
  }
}
