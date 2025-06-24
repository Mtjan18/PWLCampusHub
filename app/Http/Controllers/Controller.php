<?php

namespace App\Http\Controllers;

abstract class Controller
{
    // public function downloadCertificate($certificateId)
    // {
    //     $certificate = \App\Models\Certificate::findOrFail($certificateId);
    //     $path = storage_path('app/public/' . $certificate->certificate_url);
    //     $originalName = $certificate->original_name ?? 'certificate.pdf';
    //     return response()->download($path, $originalName);
    // }
}
