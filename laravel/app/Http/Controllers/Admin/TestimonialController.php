<?php

namespace App\Http\Controllers\Admin;

use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends AdminBaseController
{
    public function index() { return view('admin.testimonials.index', ['items' => Testimonial::orderBy('sort')->get()]); }
    public function create() { return view('admin.testimonials.form', ['item' => new Testimonial()]); }
    public function edit(Testimonial $testimonial) { return view('admin.testimonials.form', ['item' => $testimonial]); }
    public function store(Request $r) { return $this->save($r, new Testimonial()); }
    public function update(Request $r, Testimonial $testimonial) { return $this->save($r, $testimonial); }
    public function destroy(Testimonial $testimonial) { $testimonial->delete(); return redirect()->route('admin.testimonials.index')->with('success', 'Deleted'); }

    protected function save(Request $r, Testimonial $t) {
        $data = $r->validate([
            'name' => 'required|string|max:120',
            'role' => 'nullable|string|max:120',
            'quote' => 'required|string|max:800',
            'rating' => 'nullable|integer|min:1|max:5',
            'sort' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'photo' => 'nullable|image|max:5120',
        ]);
        $data['is_active'] = $r->boolean('is_active');
        $data['sort'] = (int) ($data['sort'] ?? 0);
        $data['rating'] = (int) ($data['rating'] ?? 5);
        $data['photo'] = $this->handleImageUpload($r, 'photo', $t->photo, 'uploads/testimonials');
        $t->fill($data)->save();
        return redirect()->route('admin.testimonials.index')->with('success', 'Saved');
    }
}
