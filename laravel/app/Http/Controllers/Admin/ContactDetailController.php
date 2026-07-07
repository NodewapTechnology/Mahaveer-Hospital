<?php

namespace App\Http\Controllers\Admin;

use App\Models\ContactDetail;
use Illuminate\Http\Request;

class ContactDetailController extends AdminBaseController
{
    public function edit()
    {
        $c = ContactDetail::firstOrCreate(['id' => 1]);
        return view('admin.contact-details.edit', ['item' => $c]);
    }

    public function update(Request $r)
    {
        $data = $r->validate([
            'phone_primary' => 'nullable|string|max:30',
            'phone_secondary' => 'nullable|string|max:30',
            'emergency_phone' => 'nullable|string|max:30',
            'email_primary' => 'nullable|email|max:150',
            'email_support' => 'nullable|email|max:150',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'pincode' => 'nullable|string|max:20',
            'map_embed' => 'nullable|string|max:2000',
            'opening_hours' => 'nullable|string|max:400',
        ]);
        $c = ContactDetail::firstOrCreate(['id' => 1]);
        $c->fill($data)->save();
        return redirect()->route('admin.contact-details.edit')->with('success', 'Contact details updated');
    }
}
