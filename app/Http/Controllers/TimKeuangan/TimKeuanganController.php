<?php

namespace App\Http\Controllers\TimKeuangan;

use App\Http\Controllers\Controller;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TimKeuanganController extends Controller
{
    public function dashboard()
    {
        $pendingPayments = EventRegistration::where('payment_status', 0)->count();
        $verifiedPayments = EventRegistration::where('payment_status', 1)->count();
        $refundPayments = EventRegistration::where('payment_status', 2)->count();
        $totalTransactions = EventRegistration::count();
        $totalRevenue = EventRegistration::where('payment_status', 1)
            ->with('session')
            ->get()
            ->sum(function ($reg) {
                return $reg->session->fee ?? 0;
            });

        $recentPayments = EventRegistration::with(['user', 'session.event'])
            ->orderByDesc('registered_at')
            ->take(10)
            ->get();

        return view('tim_keuangan.dashboard', compact(
            'pendingPayments',
            'verifiedPayments',
            'refundPayments',
            'totalRevenue',
            'recentPayments',
            'totalTransactions'
        ));
    }

    public function paymentsIndex()
    {
        // Get paginated registrations
        $payments = \App\Models\EventRegistration::with(['user', 'session.event'])
            ->orderByDesc('registered_at')
            ->paginate(20);

        // Create alias for use in the view
        $registrations = $payments;

        // Get all events for filter dropdown
        $events = \App\Models\Event::all();

        // Add these counting variables
        $totalTransactions = \App\Models\EventRegistration::count();
        $pendingCount = \App\Models\EventRegistration::where('payment_status', 0)->count();
        $verifiedCount = \App\Models\EventRegistration::where('payment_status', 1)->count();
        $refundCount = \App\Models\EventRegistration::where('payment_status', 2)->count();

        // Calculate statistics
        $totalAmount = \App\Models\EventRegistration::join('event_sessions', 'event_registrations.session_id', '=', 'event_sessions.id')
            ->sum('event_sessions.fee');

        $pendingAmount = \App\Models\EventRegistration::where('payment_status', 0)
            ->join('event_sessions', 'event_registrations.session_id', '=', 'event_sessions.id')
            ->sum('event_sessions.fee');

        $averageAmount = \App\Models\EventRegistration::join('event_sessions', 'event_registrations.session_id', '=', 'event_sessions.id')
            ->avg('event_sessions.fee') ?? 0;

        $mostRecentDate = \App\Models\EventRegistration::max('registered_at');

        return view('tim_keuangan.payments.index', compact(
            'registrations',
            'events',
            'totalTransactions',
            'pendingCount',
            'verifiedCount',
            'refundCount',
            'totalAmount',
            'pendingAmount',
            'averageAmount',
            'mostRecentDate'
        ));
    }

    public function verifyPayment($registrationId)
    {
        $registration = \App\Models\EventRegistration::findOrFail($registrationId);

        // Generate data unik untuk QR (misal: id registrasi terenkripsi)
        // Generate data QR dalam format JSON
        $qrData = json_encode([
            'registration_id' => $registration->id,
            'event_id' => $registration->session->event_id,
            'session_id' => $registration->session_id,
        ]);

        // Generate QR code PNG
        $qrCodeImage = QrCode::format('png')->size(300)->generate($qrData);

        // Simpan file QR code ke storage/public/qrcodes
        $fileName = 'qrcodes/qr_' . $registration->id . '.png';
        Storage::disk('public')->put($fileName, $qrCodeImage);

        // Update status pembayaran & simpan path QR code
        $registration->update([
            'payment_status' => 1, // verified
            'qr_code' => $fileName,
        ]);

        return back()->with('success', 'Pembayaran diverifikasi & QR code dibuat.');
    }
    public function showPayment($registrationId)
    {
        $registration = \App\Models\EventRegistration::with(['user', 'session.event'])
            ->findOrFail($registrationId);

        return view('tim_keuangan.payments.show', compact('registration'));
    }

    public function paymentIndex(Request $request)
    {
        // Get all events for filter dropdown
        $events = \App\Models\Event::all();

        // Build query based on filters
        $query = \App\Models\EventRegistration::query()
            ->with(['session.event', 'user'])
            ->orderBy('registered_at', 'desc');

        // Apply status filter - FIXED
        if ($request->has('status') && $request->status != '') {
            if ($request->status == 'pending') {
                $query->where('payment_status', 0);
            } elseif ($request->status == 'verified') {
                $query->where('payment_status', 1);
            } elseif ($request->status == 'refund') {
                $query->where('payment_status', 2);
            }
        }

        // Apply event filter
        if ($request->has('event') && $request->event) {
            $query->whereHas('session', function ($q) use ($request) {
                $q->where('event_id', $request->event);
            });
        }

        // Apply date filters
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('registered_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('registered_at', '<=', $request->date_to);
        }

        // Apply search filter
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })->orWhereHas('session.event', function ($eventQuery) use ($search) {
                    $eventQuery->where('name', 'like', "%{$search}%");
                });
            });
        }

        // Get paginated results with query string parameters preserved - THIS IS KEY
        $registrations = $query->paginate(10)->withQueryString();

        // Get counts for tabs
        $totalTransactions = \App\Models\EventRegistration::count();
        $pendingCount = \App\Models\EventRegistration::where('payment_status', 0)->count();
        $verifiedCount = \App\Models\EventRegistration::where('payment_status', 1)->count();
        $refundCount = \App\Models\EventRegistration::where('payment_status', 2)->count();

        // Calculate statistics
        $totalAmount = \App\Models\EventRegistration::join('event_sessions', 'event_registrations.session_id', '=', 'event_sessions.id')
            ->sum('event_sessions.fee');

        $pendingAmount = \App\Models\EventRegistration::where('payment_status', 0)
            ->join('event_sessions', 'event_registrations.session_id', '=', 'event_sessions.id')
            ->sum('event_sessions.fee');

        $averageAmount = \App\Models\EventRegistration::join('event_sessions', 'event_registrations.session_id', '=', 'event_sessions.id')
            ->avg('event_sessions.fee') ?? 0;

        $mostRecentDate = \App\Models\EventRegistration::max('registered_at');

        return view('tim_keuangan.payments.index', compact(
            'registrations',
            'events',
            'totalTransactions',
            'pendingCount',
            'verifiedCount',
            'refundCount',
            'totalAmount',
            'pendingAmount',
            'averageAmount',
            'mostRecentDate'
        ));
    }

    public function rejectPayment(Request $request, $registrationId)
    {
        $registration = \App\Models\EventRegistration::findOrFail($registrationId);

        $registration->payment_status = 2; // 2 = rejected/refund
        $registration->rejection_reason = $request->input('rejection_reason');
        $registration->rejection_notes = $request->input('rejection_notes');
        $registration->save();

        return redirect()->route('tim_keuangan.payments.index')
            ->with('success', 'Payment has been rejected.');
    }
}
