<?php

namespace App\Http\Controllers;

use App\Models\Pickup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KurirController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->isKurir()) {
                abort(403);
            }
            return $next($request);
        });
    }

    public function dashboard()
    {
        $pickups = Pickup::where('assigned_to', Auth::id())
            ->whereIn('status', ['diproses', 'dalam_perjalanan'])
            ->latest()
            ->get();

        $riwayat = Pickup::where('assigned_to', Auth::id())
            ->where('status', 'selesai')
            ->latest()
            ->limit(10)
            ->get();

        return view('kurir.dashboard', compact('pickups', 'riwayat'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diproses,dalam_perjalanan,selesai',
        ]);

        $pickup = Pickup::where('assigned_to', Auth::id())->findOrFail($id);
        $pickup->status = $request->status;

        if ($request->status === 'selesai') {
            $pickup->pickup_time = now();
        }

        if ($request->catatan) {
            $pickup->catatan = $request->catatan;
        }

        $pickup->save();

        return back()->with('success', 'Status pickup berhasil diperbarui.');
    }

    public function riwayat()
    {
        $riwayat = Pickup::where('assigned_to', Auth::id())
            ->where('status', 'selesai')
            ->latest()
            ->paginate(20);

        return view('kurir.riwayat', compact('riwayat'));
    }
}
