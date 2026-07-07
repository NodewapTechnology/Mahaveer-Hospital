<?php

namespace App\Http\Controllers\Admin;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends AdminBaseController
{
    public function index() { return view('admin.faqs.index', ['items' => Faq::orderBy('sort')->get()]); }
    public function create() { return view('admin.faqs.form', ['item' => new Faq()]); }
    public function edit(Faq $faq) { return view('admin.faqs.form', ['item' => $faq]); }
    public function store(Request $r) { return $this->save($r, new Faq()); }
    public function update(Request $r, Faq $faq) { return $this->save($r, $faq); }
    public function destroy(Faq $faq) { $faq->delete(); return redirect()->route('admin.faqs.index')->with('success', 'Deleted'); }

    protected function save(Request $r, Faq $f) {
        $data = $r->validate([
            'question' => 'required|string|max:400',
            'answer' => 'required|string',
            'sort' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);
        $data['is_active'] = $r->boolean('is_active');
        $data['sort'] = (int) ($data['sort'] ?? 0);
        $f->fill($data)->save();
        return redirect()->route('admin.faqs.index')->with('success', 'Saved');
    }
}
