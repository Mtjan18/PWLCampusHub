<?php

namespace App\Http\Controllers\Panitia;

use App\Models\Event;
use App\Models\EventSession;
use App\Models\Speaker;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\EventRegistration;

class PanitiaController extends Controller
{
    public function dashboard()
    {
        $userId = auth::id();

        $events = Event::all();


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
                ->whereBetween('event_registrations.created_at', [now()->startOfWeek(), now()->endOfWeek()])
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

        return redirect()->route('panitia.events.show', $event->id)
            ->with('success', 'Event berhasil dibuat.');
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

    public function scanAttendance(Request $request)
    {
        $events = \App\Models\Event::with('sessions')->orderBy('date')->get();
        $selectedEventId = $request->event_id ?? ($events->first()->id ?? null);
        $sessions = $selectedEventId
            ? \App\Models\EventSession::where('event_id', $selectedEventId)->orderBy('session_date')->get()
            : collect();
        $selectedSessionId = $request->session_id ?? ($sessions->first()->id ?? null);

        // Ambil peserta untuk sesi terpilih
        $registrations = $selectedSessionId
            ? \App\Models\EventRegistration::with(['user', 'attendances' => function ($q) use ($selectedSessionId) {
                $q->where('session_id', $selectedSessionId);
            }])->where('session_id', $selectedSessionId)->get()
            : collect();

        return view('panitia.attendance.scan', compact(
            'events',
            'sessions',
            'registrations',
            'selectedEventId',
            'selectedSessionId'
        ));
    }

    public function storeAttendance(Request $request)
    {
        $request->validate([
            'qr_data' => 'required',
            'session_id' => 'required|exists:event_sessions,id',
        ]);

        // Dekripsi QR (isi: id registrasi)
        try {
            $registrationId = decrypt($request->qr_data);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'QR tidak valid.']);
        }

        $registration = EventRegistration::find($registrationId);
        if (!$registration) {
            return response()->json(['status' => 'error', 'message' => 'Registrasi tidak ditemukan.']);
        }

        // Cek sudah hadir atau belum
        $already = Attendance::where('registration_id', $registrationId)
            ->where('session_id', $request->session_id)
            ->exists();

        if ($already) {
            return response()->json(['status' => 'already', 'message' => 'Peserta sudah tercatat hadir.']);
        }

        Attendance::create([
            'registration_id' => $registrationId,
            'session_id' => $request->session_id,
            'scanned_by' => Auth::id(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Presensi berhasil!',
            'registration_id' => $registrationId // <-- tambahkan ini
        ]);
    }
}
