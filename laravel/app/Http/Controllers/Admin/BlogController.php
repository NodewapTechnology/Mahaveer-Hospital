<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends AdminBaseController
{
    public function index() { return view('admin.blogs.index', ['items' => Blog::orderByDesc('published_at')->get()]); }
    public function create() { return view('admin.blogs.form', ['item' => new Blog()]); }
    public function edit(Blog $blog) { return view('admin.blogs.form', ['item' => $blog]); }
    public function store(Request $r) { return $this->save($r, new Blog()); }
    public function update(Request $r, Blog $blog) { return $this->save($r, $blog); }
    public function destroy(Blog $blog) { $blog->delete(); return redirect()->route('admin.blogs.index')->with('success', 'Deleted'); }

    protected function save(Request $r, Blog $b) {
        $data = $r->validate([
            'title' => 'required|string|max:220',
            'author' => 'nullable|string|max:120',
            'excerpt' => 'nullable|string|max:400',
            'content' => 'nullable|string',
            'published_at' => 'nullable|date',
            'is_active' => 'nullable|boolean',
            'cover_image' => 'nullable|image|max:8192',
        ]);
        $data['slug'] = $b->slug ?: Str::slug($data['title'] . '-' . substr(md5($data['title'] . microtime()), 0, 6));
        $data['is_active'] = $r->boolean('is_active');
        $data['cover_image'] = $this->handleImageUpload($r, 'cover_image', $b->cover_image, 'uploads/blogs');
        $b->fill($data)->save();
        return redirect()->route('admin.blogs.index')->with('success', 'Saved');
    }
}
