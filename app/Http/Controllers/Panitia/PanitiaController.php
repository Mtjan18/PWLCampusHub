<?php

namespace App\Http\Controllers\Panitia;

use App\Models\Event;
use App\Models\EventSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class PanitiaController extends Controller
{
    public function dashboard()
    {
        $userId = auth::id();

        // Ambil semua event yang dibuat oleh panitia ini
        $events = Event::where('created_by', $userId)->get();

        $eventCount = $events->count();

        $activeEvents = $events->filter(function ($event) {
            return $event->date >= now();
        });

        $completedEvents = $events->filter(function ($event) {
            return $event->date < now();
        });

        $activeCount = $activeEvents->count();
        $completedCount = $completedEvents->count();

        // Total registrasi
        $registrationTotal = $events->sum(function ($event) {
            return $event->registrations()->count();
        });

        // Registrasi minggu ini
        $weeklyRegistration = $events->sum(function ($event) {
            return $event->registrations()
                ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->count();
        });

        // Rate kehadiran
        $attendanceRate = 0;
        $totalAttendances = 0;
        $totalRegistrations = 0;

        foreach ($events as $event) {
            $registrations = $event->registrations()->count();
            $attendances = $event->attendances()->count(); // pastikan relasi ada
            $totalRegistrations += $registrations;
            $totalAttendances += $attendances;
        }

        if ($totalRegistrations > 0) {
            $attendanceRate = round(($totalAttendances / $totalRegistrations) * 100, 2);
        }

        // Ambil active events lengkap dengan jumlah peserta
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
        ))->with('activeEvents', $activeEventsDetailed); // agar tetap support @forelse
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
            'time' => 'required',
            'location' => 'required|string|max:255',
            'poster_url' => 'nullable|url',
            'registration_fee' => 'nullable|numeric',
            'max_participants' => 'nullable|integer',
        ]);

        $event = Event::create([
            'name' => $request->name,
            'date' => $request->date,
            'time' => $request->time,
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
            'session_time' => 'required',
            'location' => 'required|string|max:255',
        ]);

        EventSession::create([
            'event_id' => $event->id,
            'name' => $request->name,
            'session_date' => $request->session_date,
            'session_time' => $request->session_time,
            'location' => $request->location,
        ]);

        return redirect()->route('panitia.dashboard')->with('success', 'Sesi berhasil ditambahkan.');
    }
}
