<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class TimelineController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $query = Post::query();
        $posts = $query->orderByDesc('id')->get();

        return view('dashboard', compact('posts'));
    }
}