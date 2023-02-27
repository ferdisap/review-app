<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
    $postsDraft = Post::where('isDraft', '=', 1)->where('author', '=', Auth::user()->id)->orderBy('updated_at', 'desc')->paginate(9,['*'], 'draft')->withQueryString()->onEachSide(2);
    $postsPublished = Post::where('isDraft', '=', 0)->where('author', '=', Auth::user()->id)->orderBy('updated_at', 'desc')->paginate(9, ['*'], 'published')->withQueryString()->onEachSide(2);

    // dd(request()->active);
    // dd($postsDraft);
    // dd($postsPublished);

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
    $result = Post::find($id)->delete();
    if(!$result){
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
    if ($validator->fails()){
      return back()->withInput()->with('fail', 'delete post(s) failed.X');
    }

    // proses mendelete post. Jika gagal, maka akan di tambahkan ke failedDestroyedUUID dan dilabelin 'checked' supaya di UI nya di otomatis di contreng
    $failedDestroyedUUID = [];
    foreach($validator->getData()['list-post-cb'] as $uuid){
      if (!$this->destroy($uuid)){
        $failedDestroyedUUID[$uuid] = 'checked';
      };
    }
    
    // jika ada post yang gagal di hapus, maka tambahkan old input ('toogle-switch') kalo ga 'on'/'some'. Jika on artinya checkall. jika some artinya ga semua di checkall (tapi ada yang di check)
    // if validator success, $request->merge['toogle-switch'] => $request->['toogle-switch'] ?? 'some'    
    // di app.js @initialization nya jika 'toogle-switch' checked == true,  maka di toogle(true), jika false, null
    // di toogle slider htmlnya, jika checkedValue nya == 'some', jalankan @showCkBox(), jika == true, maka checked saja (tidak perlu di toogle karena sudah dilakukan oleh @initialization)
    if (($qtyFailed = count($failedDestroyedUUID)) != 0) {
      $failedDestroyedUUID['toogle-switch'] = $request['toogle-switch'] ?? 'some';
      return back()->withInput($failedDestroyedUUID)->with('fail', $qtyFailed . ' post(s) failed to delete.Y' );
    }

    // jika semua post berhasil di destroy dary DB, maka:
    return back()->withInput()->with('success', 'The selected post(s) has been deleted.' );
  }

  /**
   * 
   */
  public function search(Request $request)
  {
    if ($request->key == '' || $request->key == null ){
      $posts = null;
    } else {
      $posts = Post::search($request->key)->orderBy('updated_at')->get(['uuid', 'title', 'simpleDescription', 'detailDescription', 'isDraft']);
    }
    return response()->json([
      'posts' => $posts,
    ]);
  }
}
