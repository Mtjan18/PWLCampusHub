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
        $totalRevenue = EventRegistration::where('payment_status', 1)->with('session.event')->get()->sum(function ($reg) {
            return $reg->session->event->registration_fee ?? 0;
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
            'recentPayments'
        ));
    }

    public function paymentsIndex()
    {
        $payments = \App\Models\EventRegistration::with(['user', 'session.event'])
            ->orderByDesc('registered_at')
            ->paginate(20);

        return view('tim_keuangan.payments.index', compact('payments'));
    }

    public function verifyPayment($registrationId)
    {
        $registration = \App\Models\EventRegistration::findOrFail($registrationId);

        // Generate data unik untuk QR (misal: id registrasi terenkripsi)
        $qrData = encrypt($registration->id);

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
}
