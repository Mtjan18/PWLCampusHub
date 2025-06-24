<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EventRegistration;
use App\Models\Certificate;
use App\Models\EventSession;
use App\Models\Attendance;
use Carbon\Carbon;

class MemberController extends Controller
{


    public function events()
    {

        return view('member.events');
    }

    public function showEvent(\App\Models\Event $event)
    {
        $event->load(['sessions.speakers', 'registrations']);
        $user = Auth::user();
        $userRegistration = $event->registrations()
            ->where('user_id', $user->id)
            ->first();
        return view('member.events.show', compact('event', 'userRegistration'));
    }
    public function dashboard()
    {
        $user = Auth::user();

        // Registrasi event user
        $registrations = $user->eventRegistrations()->with('session.event')->latest()->get();

        // Statistik event
        $registeredEvents = $registrations->count();
        $upcomingEvents = $registrations->where('event.date', '>=', Carbon::today())->count();
        $completedEvents = $registrations->where('event.date', '<', Carbon::today())->count();

        // Sertifikat
        $certificates = Certificate::whereHas('registration', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->with('registration.event')->orderBy('uploaded_at', 'desc')->take(2)->get();
        $certificatesCount = Certificate::whereHas('registration', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->count();
        $pendingCertificates = $registeredEvents - $certificatesCount;

        // Payments

        $totalPaid = $registrations->where('payment_status', 1)->sum(function ($reg) {
            return $reg->session && $reg->session->event ? $reg->session->event->registration_fee : 0;
        });

        $recentPayments = $registrations->where('payment_status', '!=', null)->take(4);

        // Attendance
        $totalAttendance = $user->attendances()->count();
        $totalSessions = EventSession::whereIn('event_id', $registrations->pluck('event_id'))->count();

        return view('member.dashboard', compact(
            'user',
            'registrations',
            'registeredEvents',
            'upcomingEvents',
            'completedEvents',
            'certificates',
            'certificatesCount',
            'pendingCertificates',
            'totalPaid',
            'recentPayments',
            'totalAttendance',
            'totalSessions'
        ));
    }

    public function certificates()
    {
        $user = Auth::user();
        $certificates = \App\Models\Certificate::whereHas('registration', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->with('registration.event')->orderBy('uploaded_at', 'desc')->get();

        return view('member.certificates', compact('certificates'));
    }

    public function payments()
    {
        $user = Auth::user();
        $registrations = $user->eventRegistrations()->with('event')->whereNotNull('payment_status')->orderByDesc('registered_at')->get();

        return view('member.payments', compact('registrations'));
    }

    public function registerSession(Request $request, $eventId, $sessionId)
    {
        $user = Auth::user();

        $request->validate([
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $proofPath = $request->file('payment_proof')->store('payment_proofs', 'public');

        $exists = \App\Models\EventRegistration::where('user_id', $user->id)
            ->where('session_id', $sessionId)
            ->exists();

        if ($exists) {
            return back()->with('warning', 'Anda sudah terdaftar di sesi ini.');
        }

        \App\Models\EventRegistration::create([
            'user_id' => $user->id,
            'session_id' => $sessionId, // <-- WAJIB DIISI!
            'payment_proof_url' => $proofPath,
            'payment_status' => 0,
        ]);

        return back()->with('success', 'Registrasi berhasil! Tunggu verifikasi pembayaran.');
    }
    public function cancelRegistration($registrationId)
    {
        $registration = \App\Models\EventRegistration::where('user_id', Auth::id())
            ->findOrFail($registrationId);

        $registration->delete();

        return back()->with('success', 'Registration cancelled.');
    }
    public function registerMultipleSessions(Request $request, $eventId)
    {
        $user = Auth::user();

        $request->validate([
            'session_ids' => 'required|array|min:1',
            'session_ids.*' => 'exists:event_sessions,id',
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $proofPath = $request->file('payment_proof')->store('payment_proofs', 'public');

        $registered = 0;
        foreach ($request->session_ids as $sessionId) {
            $exists = \App\Models\EventRegistration::where('user_id', $user->id)
                ->where('session_id', $sessionId)
                ->exists();

            if (!$exists) {
                \App\Models\EventRegistration::create([
                    'user_id' => $user->id,
                    'session_id' => $sessionId,
                    'payment_proof_url' => $proofPath,
                    'payment_status' => 0,
                ]);
                $registered++;
            }
        }

        if ($registered > 0) {
            return back()->with('success', 'Berhasil mendaftar pada ' . $registered . ' sesi! Tunggu verifikasi pembayaran.');
        } else {
            return back()->with('warning', 'Anda sudah terdaftar di semua sesi yang dipilih.');
        }
    }
}
