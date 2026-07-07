<?php

namespace App\Http\Controllers\Admin;

use App\Models\SocialLink;
use Illuminate\Http\Request;

class SocialLinkController extends AdminBaseController
{
    public function index() { return view('admin.social-links.index', ['items' => SocialLink::orderBy('sort')->get()]); }
    public function create() { return view('admin.social-links.form', ['item' => new SocialLink()]); }
    public function edit(SocialLink $social_link) { return view('admin.social-links.form', ['item' => $social_link]); }
    public function store(Request $r) { return $this->save($r, new SocialLink()); }
    public function update(Request $r, SocialLink $social_link) { return $this->save($r, $social_link); }
    public function destroy(SocialLink $social_link) { $social_link->delete(); return redirect()->route('admin.social-links.index')->with('success', 'Deleted'); }

    protected function save(Request $r, SocialLink $s) {
        $data = $r->validate([
            'platform' => 'required|string|max:80',
            'icon' => 'nullable|string|max:80',
            'url' => 'required|string|max:255',
            'sort' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);
        $data['is_active'] = $r->boolean('is_active');
        $data['sort'] = (int) ($data['sort'] ?? 0);
        $s->fill($data)->save();
        return redirect()->route('admin.social-links.index')->with('success', 'Saved');
    }
}
