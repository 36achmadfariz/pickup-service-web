<?php

namespace App\Http\Controllers;

use App\Models\Pickup;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->isAdmin()) {
                abort(403);
            }
            return $next($request);
        });
    }

    public function dashboard()
    {
        $pickups = Pickup::with('kurir')->latest()->paginate(20);
        $kurirList = User::where('role', 'kurir')->get();
        $totalMenunggu = Pickup::where('status', 'menunggu')->count();
        $totalDiproses = Pickup::where('status', 'diproses')->count();
        $totalSelesai = Pickup::where('status', 'selesai')->count();
        $hariIni = Pickup::whereDate('created_at', today())->count();
        $bulanIni = Pickup::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
        $totalSemua = Pickup::count();

        return view('admin.dashboard', compact(
            'pickups', 'kurirList', 'totalMenunggu', 'totalDiproses', 'totalSelesai',
            'hariIni', 'bulanIni', 'totalSemua'
        ));
    }

    public function assign(Request $request)
    {
        $request->validate([
            'pickup_id' => 'required|exists:pickups,id',
            'kurir_id' => 'required|exists:users,id',
        ]);

        $pickup = Pickup::findOrFail($request->pickup_id);
        $pickup->assigned_to = $request->kurir_id;
        $pickup->status = 'diproses';
        $pickup->save();

        return back()->with('success', 'Pickup berhasil ditugaskan ke kurir.');
    }

    public function createKurir(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'nomor_kontak' => 'nullable|string|max:20',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'kurir',
            'nomor_kontak' => $request->nomor_kontak,
        ]);

        return redirect()->route('admin.kurir')->with('success', 'Akun kurir berhasil dibuat.');
    }

    public function search(Request $request)
    {
        $query = $request->q;
        $pickups = Pickup::with('kurir')
            ->where(function ($q) use ($query) {
                $q->where('nama', 'like', "%{$query}%")
                  ->orWhere('nomor_kontak', 'like', "%{$query}%")
                  ->orWhere('alamat_pickup', 'like', "%{$query}%")
                  ->orWhere('alamat_tujuan', 'like', "%{$query}%")
                  ->orWhere('deskripsi_barang', 'like', "%{$query}%");
            })
            ->latest()
            ->paginate(20);

        $kurirList = User::where('role', 'kurir')->get();
        $totalMenunggu = Pickup::where('status', 'menunggu')->count();
        $totalDiproses = Pickup::where('status', 'diproses')->count();
        $totalSelesai = Pickup::where('status', 'selesai')->count();
        $hariIni = Pickup::whereDate('created_at', today())->count();
        $bulanIni = Pickup::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
        $totalSemua = Pickup::count();

        return view('admin.dashboard', compact(
            'pickups', 'kurirList', 'query', 'totalMenunggu', 'totalDiproses', 'totalSelesai',
            'hariIni', 'bulanIni', 'totalSemua'
        ));
    }

    public function export(Request $request)
    {
        $period = $request->get('period', 'semua');
        $from = $request->get('from');
        $to = $request->get('to');
        $preview = $request->get('preview');
        
        $query = Pickup::with('kurir')->latest();

        if ($from && $to) {
            $query->whereDate('created_at', '>=', $from)->whereDate('created_at', '<=', $to);
            $namaFile = 'laporan-pickup-' . $from . '_sd_' . $to . '.xls';
            $label = 'Rentang ' . $from . ' s/d ' . $to;
        } elseif ($period === 'hari_ini') {
            $query->whereDate('created_at', today());
            $namaFile = 'laporan-pickup-harian-' . today()->format('Y-m-d') . '.xls';
            $label = 'Hari Ini (' . today()->format('d/m/Y') . ')';
        } elseif ($period === 'bulan_ini') {
            $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
            $namaFile = 'laporan-pickup-bulanan-' . now()->format('Y-m') . '.xls';
            $label = 'Bulan ' . now()->translatedFormat('F Y');
        } else {
            $namaFile = 'laporan-pickup-semua-' . now()->format('Y-m-d') . '.xls';
            $label = 'Semua Data';
        }

        $pickups = $query->get();

        // PREVIEW MODE — tampilkan data di dashboard
        if ($preview) {
            return back()->with('preview_data', $pickups)->with('preview_label', $label)->with('preview_count', $pickups->count());
        }

        // EXPORT MODE — download .xls
        $output = fopen('php://temp', 'r+');
        
        // Header
        fwrite($output, "ID\tNama\tEmail\tNo Kontak\tAlamat Pickup\tTujuan\tBarang\tBerat (kg)\tStatus\tKurir\tTgl Pickup\tDibuat\n");

        foreach ($pickups as $p) {
            $row = [
                $p->id,
                $p->nama,
                $p->email ?? '',
                $p->nomor_kontak,
                $p->alamat_pickup,
                $p->alamat_tujuan,
                $p->deskripsi_barang,
                $p->berat_kg ?? '',
                match($p->status) {
                    'menunggu' => 'Menunggu',
                    'diproses' => 'Diproses',
                    'dalam_perjalanan' => 'Dalam Perjalanan',
                    'selesai' => 'Selesai',
                    default => $p->status,
                },
                $p->kurir?->name ?? '-',
                $p->pickup_time ?? '-',
                $p->created_at instanceof \Carbon\Carbon ? $p->created_at->format('d/m/Y H:i') : $p->created_at,
            ];
            // Bersihin tab dan newline dari data
            $clean = array_map(function($v) {
                return str_replace(["\t", "\n", "\r"], [' ', ' ', ''], (string)$v);
            }, $row);
            fwrite($output, implode("\t", $clean) . "\n");
        }

        rewind($output);
        $content = stream_get_contents($output);
        fclose($output);

        return response($content)
            ->header('Content-Type', 'application/vnd.ms-excel; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $namaFile . '"');
    }

    public function kurir()
    {
        $kurirList = User::where('role', 'kurir')->get();
        return view('admin.kurir', compact('kurirList'));
    }

    public function riwayat()
    {
        $riwayat = Pickup::with('kurir')->where('status', 'selesai')->latest()->paginate(20);
        return view('admin.riwayat', compact('riwayat'));
    }

    public function deletePickup($id)
    {
        $pickup = Pickup::findOrFail($id);
        $pickup->delete();
        return back()->with('success', 'Pickup #'.$id.' berhasil dihapus.');
    }

    public function deleteKurir($id)
    {
        $kurir = User::where('role', 'kurir')->findOrFail($id);
        Pickup::where('assigned_to', $id)->update(['assigned_to' => null, 'status' => 'menunggu']);
        $kurir->delete();
        return redirect()->route('admin.kurir')->with('success', 'Akun kurir berhasil dihapus.');
    }
}
