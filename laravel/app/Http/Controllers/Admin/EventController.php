<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends AdminBaseController
{
    public function index() { return view('admin.events.index', ['items' => Event::orderByDesc('event_date')->get()]); }
    public function create() { return view('admin.events.form', ['item' => new Event()]); }
    public function edit(Event $event) { return view('admin.events.form', ['item' => $event]); }
    public function store(Request $r) { return $this->save($r, new Event()); }
    public function update(Request $r, Event $event) { return $this->save($r, $event); }
    public function destroy(Event $event) { $event->delete(); return redirect()->route('admin.events.index')->with('success', 'Deleted'); }

    protected function save(Request $r, Event $e) {
        $data = $r->validate([
            'title' => 'required|string|max:200',
            'event_date' => 'required|date',
            'event_time' => 'nullable|string|max:20',
            'venue' => 'nullable|string|max:200',
            'short_description' => 'nullable|string|max:400',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'image' => 'nullable|image|max:8192',
        ]);
        $data['slug'] = $e->slug ?: Str::slug($data['title'] . '-' . substr(md5($data['title'] . microtime()), 0, 6));
        $data['is_active'] = $r->boolean('is_active');
        $data['image'] = $this->handleImageUpload($r, 'image', $e->image, 'uploads/events');
        $e->fill($data)->save();
        return redirect()->route('admin.events.index')->with('success', 'Saved');
    }
}
