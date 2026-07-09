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
                    ->orWhere('village', 'like', "%$s%")
                    ->orWhere('district', 'like', "%$s%")
                    ->orWhere('subject', 'like', "%$s%")
                    ->orWhere('message', 'like', "%$s%");
            });
        }
        if ($status = $r->get('status')) {
            $q->where('status', $status);
        }
        if ($source = $r->get('source')) {
            $q->where('source', $source);
        }
        // Date filter — by appointment date (preferred_date)
        if ($date = $r->get('date')) {
            $q->where('preferred_date', $date);
        }
        // Date range shortcut
        if ($r->get('range') === 'today') {
            $q->whereDate('created_at', now()->toDateString());
        } elseif ($r->get('range') === 'week') {
            $q->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        }

        $onlineAppointmentsCount = Enquiry::where('source', 'hero_form')->count();
        $totalCount = Enquiry::count();
        $todayCount = Enquiry::whereDate('created_at', now()->toDateString())->count();

        return view('admin.enquiries.index', [
            'items' => $q->latest()->paginate(20)->withQueryString(),
            'search' => $s ?? '',
            'status' => $status ?? '',
            'source' => $source ?? '',
            'date' => $date ?? '',
            'range' => $r->get('range', ''),
            'onlineAppointmentsCount' => $onlineAppointmentsCount,
            'totalCount' => $totalCount,
            'todayCount' => $todayCount,
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
