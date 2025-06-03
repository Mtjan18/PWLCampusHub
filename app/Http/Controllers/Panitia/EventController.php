<?php

namespace App\Http\Controllers\Panitia;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function show(Event $event)
    {
        return view('panitia.events.show', compact('event'));
    }

    public function publicIndex(Request $request)
    {
        $query = Event::query();

        // Filter (optional, jika ingin filter dari form)
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('date')) {
            // Implementasi filter tanggal sesuai kebutuhan
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $events = $query->orderBy('date', 'asc')->paginate(9);

        return view('events', compact('events'));
    }
}
