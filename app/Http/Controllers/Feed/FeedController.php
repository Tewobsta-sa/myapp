<?php

namespace App\Http\Controllers\Feed;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Feed;
use Illuminate\Foundation\Providers\FoundationServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\like;
use App\Models\Comment;

class FeedController extends Controller
{

    public function index(){
        $feeds = Feed::with('user')->latest()->get();
        return response([
            'feeds'=>$feeds
        ], 200);
    }
    public function store(PostRequest $request){
        $request->validated();

        $request-> user()->feeds()->create([
            'content' =>$request->content
        ]);

        return response([
            'message'=>'success'
        ], 201);
    }

    public function likePost($feed_id){
        $feed= Feed::whereId($feed_id)->first();

        if(!$feed){
            return response([
                'message'=>'404 Not found'
            ], 500);
        }

        //unlike post
        $unlike_post = Like::where('user_id', Auth::id())->where('feed_id', $feed_id)->delete();
        if($unlike_post){
            return response([
                'message'=>'unliked'
            ], 200);
        }

        $like_post = Like::create([
            'user_id'=> Auth::id(),
            'feed_id'=> $feed_id
        ]);
        
        if($like_post){
            return response([
                'message'=>'liked'
            ], 200);
        }

        
    }

    public function comment(Request $request, $feed_id){

        $request->validate([
            'body' => 'required|string|min:1'
        ]);

        $comment=Comment::create([
            'user_id' => Auth::id(),
            'feed_id' => $feed_id,
            'body' => $request->body
        ]);

        return response([
            'message' => 'success'
        ], 201);
   }

   public function getComments($feed_id){
    $comments = Comment::with(['user', 'feed'])->whereFeedId($feed_id)->latest()->get();

    return response([
        'comments'=>$comments
    ] ,200);
   }

}
