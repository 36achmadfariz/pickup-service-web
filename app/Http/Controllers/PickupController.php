<?php

namespace App\Http\Controllers;

use App\Models\Pickup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PickupController extends Controller
{
    // Form publik - no auth
    public function create()
    {
        return view('pickup.create');
    }

    public function store(Request $request)
    {
        // --- LAYER 1: Honeypot ---
        if (!empty($request->input('website'))) {
            // Bot filled the hidden field — silently fake success
            return redirect('/')->with('success', 'Request pickup berhasil dikirim! Tim kami akan segera memproses.');
        }

        // --- LAYER 2: Email blacklist (disposable domains) ---
        $blacklist = [
            'mailinator.com', 'guerrillamail.com', '10minutemail.com', 'tempmail.com',
            'throwaway.email', 'yopmail.com', 'sharklasers.com', 'guerrillamail.info',
            'guerrillamail.org', 'guerrillamail.net', 'guerrillamail.biz', 'guerrillamail.de',
            'maildrop.cc', 'temp-mail.org', 'dispostable.com', 'trashmail.com',
            'getairmail.com', 'fakeinbox.com', 'emailondeck.com', 'spam4.me',
            'wegwerfmail.de', 'wegwerfmail.net', 'wegwerfmail.org', 'nwytg.com',
            'moakt.cc', 'byom.de', 'deadaddress.com', 'mytemp.email',
            'mailexpire.com', 'mintemail.com', 'spambox.us', 'opayq.com',
        ];
        $emailDomain = substr(strrchr($request->input('email'), '@'), 1);
        if (in_array(strtolower($emailDomain), $blacklist)) {
            return back()->withInput()->withErrors(['email' => 'Mohon gunakan email aktif yang valid.']);
        }

        // --- LAYER 3: reCAPTCHA v3 ---
        $recaptchaResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('g-recaptcha-response'),
        ]);
        $recaptchaData = $recaptchaResponse->json();
        $score = $recaptchaData['score'] ?? ($recaptchaData['success'] ? 1.0 : 0);
        if ($score < 0.5) {
            return back()->withInput()->withErrors(['recaptcha' => 'Verifikasi keamanan gagal. Silakan coba lagi.']);
        }

        // --- Validation ---
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'nomor_kontak' => 'required|string|max:20',
            'alamat_pickup' => 'required|string|max:255',
            'alamat_tujuan' => 'required|string|max:255',
            'deskripsi_barang' => 'required|string',
            'berat_kg' => 'nullable|numeric|min:0',
        ]);

        $pickup = Pickup::create($validated + ['status' => 'menunggu']);

        return redirect()->route('pickup.success', $pickup->id)
            ->with('success', 'Request pickup berhasil dikirim! Tim kami akan segera memproses.');
    }

    public function success($id)
    {
        $pickup = Pickup::findOrFail($id);
        return view('pickup.success', compact('pickup'));
    }

    public function cancelForm($id)
    {
        $pickup = Pickup::findOrFail($id);
        if ($pickup->status !== 'menunggu') {
            return back()->with('error', 'Pickup sudah diproses, tidak dapat dibatalkan.');
        }
        return view('pickup.cancel', compact('pickup'));
    }

    public function cancel(Request $request, $id)
    {
        $pickup = Pickup::where('status', 'menunggu')->findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'nomor_kontak' => 'required',
        ]);

        if ($pickup->nama !== $request->nama || $pickup->nomor_kontak !== $request->nomor_kontak) {
            return back()->withErrors(['nama' => 'Nama atau nomor kontak tidak cocok dengan data pickup.']);
        }

        $pickup->delete();
        return redirect('/')->with('success', 'Pickup #'.$id.' berhasil dibatalkan.');
    }
}
