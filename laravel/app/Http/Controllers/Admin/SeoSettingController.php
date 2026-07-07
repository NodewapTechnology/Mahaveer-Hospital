<?php

namespace App\Http\Controllers\Admin;

use App\Models\SeoSetting;
use Illuminate\Http\Request;

class SeoSettingController extends AdminBaseController
{
    public function index() { return view('admin.seo.index', ['items' => SeoSetting::orderBy('page_key')->get()]); }
    public function edit(SeoSetting $seo_setting) { return view('admin.seo.form', ['item' => $seo_setting]); }
    public function update(Request $r, SeoSetting $seo_setting) {
        $data = $r->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:500',
            'keywords' => 'nullable|string|max:500',
            'og_image' => 'nullable|image|max:5120',
        ]);
        $data['og_image'] = $this->handleImageUpload($r, 'og_image', $seo_setting->og_image, 'uploads/seo');
        $seo_setting->fill($data)->save();
        return redirect()->route('admin.seo-settings.index')->with('success', 'SEO updated');
    }
    public function destroy(SeoSetting $seo_setting) { $seo_setting->delete(); return redirect()->route('admin.seo-settings.index')->with('success', 'Deleted'); }
}
