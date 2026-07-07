<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends AdminBaseController
{
    public function index() { return view('admin.services.index', ['items' => Service::orderBy('sort')->get()]); }
    public function create() { return view('admin.services.form', ['item' => new Service()]); }
    public function edit(Service $service) { return view('admin.services.form', ['item' => $service]); }
    public function store(Request $r) { return $this->save($r, new Service()); }
    public function update(Request $r, Service $service) { return $this->save($r, $service); }
    public function destroy(Service $service) { $service->delete(); return redirect()->route('admin.services.index')->with('success', 'Deleted'); }

    protected function save(Request $r, Service $s) {
        $data = $r->validate([
            'name' => 'required|string|max:150',
            'short_description' => 'nullable|string|max:300',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:80',
            'features' => 'nullable|array',
            'sort' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'image' => 'nullable|image|max:5120',
        ]);
        $data['slug'] = $s->slug ?: Str::slug($data['name']);
        if (!$s->exists) {
            $base = $data['slug']; $i = 1;
            while (Service::where('slug', $data['slug'])->exists()) { $data['slug'] = $base . '-' . (++$i); }
        }
        $data['is_active'] = $r->boolean('is_active');
        $data['sort'] = (int) ($data['sort'] ?? 0);
        $data['features'] = array_values(array_filter($data['features'] ?? [], fn($f) => trim((string)$f) !== ''));
        $data['image'] = $this->handleImageUpload($r, 'image', $s->image, 'uploads/services');
        $s->fill($data)->save();
        return redirect()->route('admin.services.index')->with('success', 'Saved');
    }
}
