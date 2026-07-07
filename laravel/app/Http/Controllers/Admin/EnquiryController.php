<?php

namespace App\Http\Controllers\Admin;

use App\Models\Enquiry;
use Illuminate\Http\Request;

class EnquiryController extends AdminBaseController
{
    public function index(Request $r)
    {
        $q = Enquiry::query();
        if ($s = $r->get('q')) {
            $q->where(function ($qq) use ($s) {
                $qq->where('name', 'like', "%$s%")
                    ->orWhere('phone', 'like', "%$s%")
                    ->orWhere('email', 'like', "%$s%")
                    ->orWhere('subject', 'like', "%$s%")
                    ->orWhere('message', 'like', "%$s%");
            });
        }
        if ($status = $r->get('status')) $q->where('status', $status);
        return view('admin.enquiries.index', [
            'items' => $q->latest()->paginate(20)->withQueryString(),
            'search' => $s ?? '',
            'status' => $status ?? '',
        ]);
    }

    public function show(Enquiry $enquiry) { return view('admin.enquiries.show', ['item' => $enquiry]); }

    public function update(Request $r, Enquiry $enquiry)
    {
        $data = $r->validate([
            'status' => 'required|in:new,in_progress,resolved,closed',
            'admin_notes' => 'nullable|string|max:2000',
        ]);
        $enquiry->fill($data)->save();
        return redirect()->route('admin.enquiries.show', $enquiry)->with('success', 'Enquiry updated');
    }

    public function destroy(Enquiry $enquiry) { $enquiry->delete(); return redirect()->route('admin.enquiries.index')->with('success', 'Deleted'); }
}
