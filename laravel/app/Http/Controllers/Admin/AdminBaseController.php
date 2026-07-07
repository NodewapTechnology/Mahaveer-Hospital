<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

abstract class AdminBaseController extends Controller
{
    protected function handleImageUpload(Request $request, string $field, ?string $existing = null, string $folder = 'uploads'): ?string
    {
        if ($request->hasFile($field)) {
            $file = $request->file($field);
            $name = Str::random(12) . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/' . $folder), $name);
            return 'images/' . $folder . '/' . $name;
        }
        return $existing;
    }
}
