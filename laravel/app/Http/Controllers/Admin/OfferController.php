<?php

namespace App\Http\Controllers\Admin;

use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OfferController extends AdminBaseController
{
    public function index() { return view('admin.offers.index', ['items' => Offer::latest()->get()]); }
    public function create() { return view('admin.offers.form', ['item' => new Offer()]); }
    public function edit(Offer $offer) { return view('admin.offers.form', ['item' => $offer]); }
    public function store(Request $r) { return $this->save($r, new Offer()); }
    public function update(Request $r, Offer $offer) { return $this->save($r, $offer); }
    public function destroy(Offer $offer) { $offer->delete(); return redirect()->route('admin.offers.index')->with('success', 'Deleted'); }

    protected function save(Request $r, Offer $o) {
        $data = $r->validate([
            'title' => 'required|string|max:200',
            'badge' => 'nullable|string|max:80',
            'short_description' => 'nullable|string|max:400',
            'description' => 'nullable|string',
            'valid_from' => 'nullable|date',
            'valid_until' => 'nullable|date',
            'discount_label' => 'nullable|string|max:80',
            'is_active' => 'nullable|boolean',
            'image' => 'nullable|image|max:8192',
        ]);
        $data['slug'] = $o->slug ?: Str::slug($data['title'] . '-' . substr(md5($data['title'] . microtime()), 0, 6));
        $data['is_active'] = $r->boolean('is_active');
        $data['image'] = $this->handleImageUpload($r, 'image', $o->image, 'uploads/offers');
        $o->fill($data)->save();
        return redirect()->route('admin.offers.index')->with('success', 'Saved');
    }
}
