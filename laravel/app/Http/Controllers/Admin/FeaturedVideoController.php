<?php

namespace App\Http\Controllers\Admin;

use App\Models\FeaturedVideo;
use Illuminate\Http\Request;

class FeaturedVideoController extends AdminBaseController
{
    public function index()
    {
        return view('admin.videos.index', ['items' => FeaturedVideo::orderBy('sort')->orderBy('id')->get()]);
    }

    public function create() { return view('admin.videos.form', ['item' => new FeaturedVideo(['platform' => 'instagram'])]); }
    public function edit(FeaturedVideo $video) { return view('admin.videos.form', ['item' => $video]); }
    public function store(Request $r) { return $this->save($r, new FeaturedVideo()); }
    public function update(Request $r, FeaturedVideo $video) { return $this->save($r, $video); }
    public function destroy(FeaturedVideo $video) { $video->delete(); return redirect()->route('admin.videos.index')->with('success', 'Video link deleted'); }

    protected function save(Request $r, FeaturedVideo $v)
    {
        $data = $r->validate([
            'platform' => 'required|in:instagram,youtube',
            'title' => 'nullable|string|max:150',
            'url' => 'required|url|max:400',
            'sort' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);
        $data['is_active'] = $r->boolean('is_active');
        $data['sort'] = (int) ($data['sort'] ?? 0);
        $v->fill($data)->save();
        return redirect()->route('admin.videos.index')->with('success', 'Video link saved');
    }
}
