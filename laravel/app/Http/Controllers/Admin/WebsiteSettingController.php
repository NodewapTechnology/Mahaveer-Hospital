<?php

namespace App\Http\Controllers\Admin;

use App\Models\WebsiteSetting;
use Illuminate\Http\Request;

class WebsiteSettingController extends AdminBaseController
{
    public function edit()
    {
        $s = WebsiteSetting::firstOrCreate(['id' => 1], ['site_name' => 'Mahaveer Hospital']);
        return view('admin.website-settings.edit', ['item' => $s]);
    }

    public function update(Request $r)
    {
        $data = $r->validate([
            'site_name' => 'required|string|max:150',
            'tagline' => 'nullable|string|max:250',
            'footer_text' => 'nullable|string|max:400',
            'copyright_text' => 'nullable|string|max:250',
            'appointment_cta_label' => 'nullable|string|max:80',
            'primary_color' => 'nullable|string|max:20',
            'accent_color' => 'nullable|string|max:20',
            'logo' => 'nullable|image|max:5120',
            'favicon' => 'nullable|image|max:2048',
        ]);
        $s = WebsiteSetting::firstOrCreate(['id' => 1]);
        $data['logo'] = $this->handleImageUpload($r, 'logo', $s->logo, 'uploads/settings');
        $data['favicon'] = $this->handleImageUpload($r, 'favicon', $s->favicon, 'uploads/settings');
        $s->fill($data)->save();
        return redirect()->route('admin.website-settings.edit')->with('success', 'Website settings updated');
    }
}
