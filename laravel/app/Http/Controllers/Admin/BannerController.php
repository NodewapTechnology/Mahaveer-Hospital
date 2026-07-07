<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends AdminBaseController
{
    public function index()
    {
        return view('admin.banners.index', ['items' => Banner::orderBy('sort')->get()]);
    }
    public function create() { return view('admin.banners.form', ['item' => new Banner()]); }
    public function edit(Banner $banner) { return view('admin.banners.form', ['item' => $banner]); }
    public function store(Request $request) { return $this->save($request, new Banner()); }
    public function update(Request $request, Banner $banner) { return $this->save($request, $banner); }
    public function destroy(Banner $banner) { $banner->delete(); return redirect()->route('admin.banners.index')->with('success', 'Banner deleted'); }

    protected function save(Request $r, Banner $b) {
        $data = $r->validate([
            'title' => 'required|string|max:200', 'subtitle' => 'nullable|string',
            'badge' => 'nullable|string|max:120', 'cta_text' => 'nullable|string|max:80',
            'cta_link' => 'nullable|string|max:255', 'sort' => 'nullable|integer',
            'is_active' => 'nullable|boolean', 'image' => 'nullable|image|max:5120',
        ]);
        $data['is_active'] = $r->boolean('is_active');
        $data['sort'] = (int) ($data['sort'] ?? 0);
        $data['image'] = $this->handleImageUpload($r, 'image', $b->image, 'uploads/banners');
        $b->fill($data)->save();
        return redirect()->route('admin.banners.index')->with('success', 'Saved successfully');
    }
}
