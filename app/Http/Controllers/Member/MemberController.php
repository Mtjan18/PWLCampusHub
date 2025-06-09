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
    public function dashboard()
    {
        $user = Auth::user();

        // Registrasi event user
        $registrations = $user->eventRegistrations()->with('event')->latest()->get();

        // Statistik event
        $registeredEvents = $registrations->count();
        $upcomingEvents = $registrations->where('event.date', '>=', Carbon::today())->count();
        $completedEvents = $registrations->where('event.date', '<', Carbon::today())->count();

        // Sertifikat
        $certificates = Certificate::whereHas('registration', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->with('registration.event')->latest()->take(2)->get();
        $certificatesCount = Certificate::whereHas('registration', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->count();
        $pendingCertificates = $registeredEvents - $certificatesCount;

        // Payments
        $totalPaid = $registrations->where('payment_status', 1)->sum(function ($reg) {
            return $reg->event->registration_fee ?? 0;
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

    // Tambahkan method lain sesuai kebutuhan, misal:
    // public function events() { ... }
    // public function payments() { ... }
    // public function certificates() { ... }
}
