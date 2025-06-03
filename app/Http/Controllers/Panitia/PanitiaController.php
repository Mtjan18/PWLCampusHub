<?php

namespace App\Http\Controllers\Panitia;

use App\Models\Event;
use App\Models\EventSession;
use App\Models\Speaker;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class PanitiaController extends Controller
{
    public function dashboard()
    {
        $userId = auth::id();

        $events = Event::where('created_by', $userId)->get();

        $eventCount = $events->count();

        $activeEvents = $events->filter(function ($event) {
            return $event->date >= now() && $event->status == 1;
        });


        $completedEvents = $events->filter(function ($event) {
            return $event->date < now();
        });

        $activeCount = $activeEvents->count();
        $completedCount = $completedEvents->count();

        $registrationTotal = $events->sum(function ($event) {
            return $event->registrations()->count();
        });

        $weeklyRegistration = $events->sum(function ($event) {
            return $event->registrations()
                ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->count();
        });

        $attendanceRate = 0;
        $totalAttendances = 0;
        $totalRegistrations = 0;

        foreach ($events as $event) {
            $registrations = $event->registrations()->count();
            $attendances = $event->attendances()->count();
            $totalRegistrations += $registrations;
            $totalAttendances += $attendances;
        }

        if ($totalRegistrations > 0) {
            $attendanceRate = round(($totalAttendances / $totalRegistrations) * 100, 2);
        }

        $activeEventsDetailed = Event::withCount('registrations')
            ->where('created_by', $userId)
            ->where('date', '>=', now())
            ->get();

        return view('panitia.dashboard', compact(
            'eventCount',
            'activeCount',
            'completedCount',
            'registrationTotal',
            'weeklyRegistration',
            'attendanceRate',
            'activeEventsDetailed'
        ))->with('activeEvents', $activeEventsDetailed);
    }

    public function createEvent()
    {
        return view('panitia.events.create');
    }

    public function storeEvent(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:200',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'location' => 'required|string|max:255',
            'poster_url' => 'nullable|url',
            'registration_fee' => 'nullable|numeric',
            'max_participants' => 'nullable|integer',
        ]);

        $event = Event::create([
            'name' => $request->name,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'location' => $request->location,
            'poster_url' => $request->poster_url,
            'registration_fee' => $request->registration_fee ?? 0.00,
            'max_participants' => $request->max_participants ?? 0,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('panitia.sessions.create', $event->id)
            ->with('success', 'Event berhasil dibuat. Tambahkan sesi sekarang.');
    }

    public function createSession(Event $event)
    {
        return view('panitia.sessions.create', compact('event'));
    }

    public function storeSession(Request $request, Event $event)
    {
        $request->validate([
            'name' => 'required|string|max:200',
            'session_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'location' => 'required|string|max:255',
            'speakers.*' => 'nullable|string|max:100',
        ]);

        $session = EventSession::create([
            'event_id' => $event->id,
            'name' => $request->name,
            'session_date' => $request->session_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'location' => $request->location,
        ]);

        if ($request->has('speakers')) {
            foreach ($request->speakers as $speakerName) {
                if (!empty($speakerName)) {
                    Speaker::create([
                        'session_id' => $session->id,
                        'name' => $speakerName,
                    ]);
                }
            }
        }

        return redirect()->route('panitia.dashboard')->with('success', 'Sesi dan speakers berhasil dibuat.');
    }

    public function createSpeaker(EventSession $session)
    {
        return view('panitia.speakers.create', compact('session'));
    }

    public function storeSpeaker(Request $request, EventSession $session)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        Speaker::create([
            'session_id' => $session->id,
            'name' => $request->name,
        ]);

        return redirect()->route('panitia.dashboard')->with('success', 'Speaker berhasil ditambahkan.');
    }

    
}
