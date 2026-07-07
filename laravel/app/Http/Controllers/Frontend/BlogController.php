<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;

class BlogController extends Controller
{
    public function index()
    {
        return view('frontend.blogs', [
            'blogs' => Blog::where('is_active', true)->orderByDesc('published_at')->get(),
        ]);
    }

    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('frontend.blog-show', [
            'blog' => $blog,
            'related' => Blog::where('is_active', true)->where('id', '!=', $blog->id)->take(3)->get(),
        ]);
    }
}
