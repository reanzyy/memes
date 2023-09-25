<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function create()
    {
        return view('pages.posts.create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'photo' => 'nullable',
                'identifier' => 'unique',
                'body' => 'required|max:255'
            ],
            [
                'body.required' => '',
                'body.max' => 'Maksimal 255 karakter',
            ]
        );

        $post = new Post;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/statuses', $filename);

            $post->photo = "statuses/{$filename}";
        }

        $post->user_id = Auth::user()->id;
        $post->identifier = Str::random(20);
        $post->body = $request->body;
        $post->save();

        return redirect()->route('dashboard')->withSuccess('Postingan berhasil dibuat');
    }

    public function show(Post $post, Comment $comments)
    {

        $comment =  $comments->where('post_id', $post->id)->orderByDesc('id')->get();

        return view('pages.posts.show', compact('post', 'comment'));
    }

    public function comment(Request $request)
    {

        $request->validate([
            'body' => 'required'
        ]);

        $comment = new Comment();
        $comment->user_id = auth()->user()->id;
        $comment->post_id = $request->post_id;
        $comment->body = $request->body;
        $comment->save();

        return redirect()->back()->with('success', 'Komentar berhasil dikirim');
    }

    public function delete(Post $post)
    {

        $post->delete();

        return redirect()->back()->with('success', 'Post berhasil dihapus');
    }

    public function like(Post $post)
    {
        $user = Auth::user();

        $like = Like::where('user_id', $user->id)
            ->where('post_id', $post->id)
            ->first();

        if (!$like) {
            Like::create([
                'user_id' => $user->id,
                'post_id' => $post->id,
            ]);
        } else {
            $like->delete();
        }

        return redirect()->back();
    }
}