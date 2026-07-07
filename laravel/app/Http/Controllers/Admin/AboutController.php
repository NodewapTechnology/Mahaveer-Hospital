<?php

namespace App\Http\Controllers\Admin;

use App\Models\AboutPage;
use Illuminate\Http\Request;

class AboutController extends AdminBaseController
{
    public function edit()
    {
        $about = AboutPage::firstOrCreate(['id' => 1], ['heading' => 'About Us']);
        return view('admin.about.edit', ['item' => $about]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'heading' => 'required|string|max:200',
            'overline' => 'nullable|string|max:120',
            'intro' => 'nullable|string',
            'body' => 'nullable|string',
            'stats' => 'nullable|array',
            'values' => 'nullable|array',
            'image' => 'nullable|image|max:5120',
        ]);
        $about = AboutPage::firstOrCreate(['id' => 1]);
        $data['image'] = $this->handleImageUpload($request, 'image', $about->image, 'uploads/about');

        // Clean stats/values arrays
        if (isset($data['stats'])) {
            $data['stats'] = array_values(array_filter($data['stats'], fn($s) => !empty($s['label']) || !empty($s['value'])));
        }
        if (isset($data['values'])) {
            $data['values'] = array_values(array_filter($data['values'], fn($v) => !empty($v['title']) || !empty($v['body'])));
        }
        $about->fill($data)->save();
        return redirect()->route('admin.about.edit')->with('success', 'About page updated');
    }
}
