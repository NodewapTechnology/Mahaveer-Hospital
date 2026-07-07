<?php

namespace App\Http\Controllers\Admin;

use App\Models\GalleryItem;
use Illuminate\Http\Request;

class GalleryController extends AdminBaseController
{
    public function index() { return view('admin.gallery.index', ['items' => GalleryItem::orderBy('sort')->get()]); }
    public function create() { return view('admin.gallery.form', ['item' => new GalleryItem()]); }
    public function edit(GalleryItem $gallery) { return view('admin.gallery.form', ['item' => $gallery]); }
    public function store(Request $r) { return $this->save($r, new GalleryItem()); }
    public function update(Request $r, GalleryItem $gallery) { return $this->save($r, $gallery); }
    public function destroy(GalleryItem $gallery) { $gallery->delete(); return redirect()->route('admin.gallery.index')->with('success', 'Deleted'); }

    protected function save(Request $r, GalleryItem $g) {
        $data = $r->validate([
            'title' => 'nullable|string|max:200',
            'category' => 'nullable|string|max:100',
            'caption' => 'nullable|string|max:300',
            'sort' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'image' => 'nullable|image|max:8192',
        ]);
        $data['is_active'] = $r->boolean('is_active');
        $data['sort'] = (int) ($data['sort'] ?? 0);
        $uploaded = $this->handleImageUpload($r, 'image', $g->image, 'uploads/gallery');
        if ($uploaded) $data['image'] = $uploaded;
        if (!$g->exists && empty($data['image'])) {
            return back()->withErrors(['image' => 'Please upload an image.'])->withInput();
        }
        $g->fill($data)->save();
        return redirect()->route('admin.gallery.index')->with('success', 'Saved');
    }
}
