<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Enquiry;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('frontend.contact', [
            'doctors' => Doctor::where('is_active', true)->orderBy('sort')->get(['id', 'name']),
        ]);
    }

    public function submit(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'email' => 'nullable|email|max:150',
            'phone' => 'required|string|max:20',
            'subject' => 'nullable|string|max:200',
            'message' => 'nullable|string|max:2000',
            'preferred_doctor' => 'nullable|string|max:150',
            'preferred_date' => 'nullable|string|max:50',
            'source' => 'nullable|string|max:50',
        ]);
        $data['source'] = $data['source'] ?? ($request->is('enquiry') ? 'appointment' : 'contact');
        $enquiry = Enquiry::create($data);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Thank you! Our team will call you back shortly.', 'id' => $enquiry->id]);
        }

        return redirect()->route('contact')->with('success', 'Thank you! Our team will contact you within a few hours.');
    }
}
