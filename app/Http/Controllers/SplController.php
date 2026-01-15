<?php

namespace App\Http\Controllers;

use App\Models\Spl;
use App\Models\SplDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class SplController extends Controller
{
    // --- FUNGSI UNTUK SUPERVISOR ---
    public function create() {
    // Ambil semua karyawan yang satu bagian (section) dengan Supervisor
    $karyawans = \App\Models\User::where('section', auth()->user()->section)
                ->where('role', 'Karyawan')
                ->orderBy('name', 'asc') // Urutkan nama agar pencarian lebih mudah
                ->get();

    return view('spl.create', compact('karyawans'));
    }

    public function store(Request $request) {
        // Logika simpan SPL dan detailnya di sini
        $request->validate([
            'tanggal' => 'required|date',
            'karyawan_ids' => 'required|array',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        // 1. Buat Header SPL [cite: 30]
        $spl = Spl::create([
            'no_spl' => 'SPL-' . time(),
            'tanggal' => $request->tanggal,
            'status_approval' => 'Waiting Manager', // Alur pertama ke Manager 
            'created_by' => Auth::id(),
        ]);

        // 2. Simpan Detail untuk setiap karyawan yang dipilih [cite: 30, 47]
        foreach ($request->karyawan_ids as $userId) {
            SplDetail::create([
                'spl_id' => $spl->id,
                'user_id' => $userId,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                // Total jam dihitung kasar dulu, konversi nanti oleh Admin SDM [cite: 27, 33]
            ]);
        }  

        return redirect()->route('dashboard')->with('success', 'Overtime letter has been successfully created and sent to the Manager.');
    }

    // --- FUNGSI UNTUK MANAGER --
    public function indexManager()
    {
        // Manager hanya melihat SPL dari departemen yang sama yang statusnya Waiting Manager
        $spls = Spl::whereHas('creator', function($query) {
            $query->where('department', Auth::user()->department);
        })->where('status_approval', 'Waiting Manager')->get();

        return view('manager.index', compact('spls'));
    }

    public function approveManager($id)
    {
        $spl = Spl::findOrFail($id);
        $spl->update(['status_approval' => 'Waiting SDM']);
        return redirect()->route('manager.index')->with('success', 'Overtime Approved.');
    }

    public function rejectManager($id)
    {
        $spl = Spl::findOrFail($id);
        
        // Update status menjadi Rejected
        $spl->update(['status_approval' => 'Rejected']); 
        
        return redirect()->route('manager.index')->with('success', 'Overtime arejected.');
    }

    // --- FUNGSI UNTUK ADMIN SDM ---
    public function indexSdm()
    {
        $spls = Spl::with('details.user')->where('status_approval', 'Waiting SDM')->get();
        return view('sdm.index', compact('spls'));
    }

    public function approveSdm(Request $request, $id)
    {
        $request->validate(['jenis_lembur' => 'required|in:Reguler,Off']);
        $spl = Spl::findOrFail($id);

        $spl->update([
            'jenis_lembur' => $request->jenis_lembur,
            'status_approval' => 'Approved'
        ]);

        foreach ($spl->details as $detail) {
            // Logika perhitungan jam (Sederhana: selisih jam)
            $start = \Carbon\Carbon::parse($detail->jam_mulai);
            $end = \Carbon\Carbon::parse($detail->jam_selesai);

            // 2. Logika pengaman jika lembur melewati tengah malam (misal 22:00 ke 01:00)
            if ($end->lessThan($start)) {
                $end->addDay(); 
            }
            
            $totalJam = $start->diffInHours($end);
            
            // Panggil fungsi hitungKonversi di Model SplDetail
            $konversi = $detail->hitungKonversi($request->jenis_lembur, $totalJam);
            
            $detail->update([
                'total_jam' => $totalJam,
                'total_konversi' => $konversi
            ]);
        }

        return redirect()->route('sdm.index')->with('success', 'Overtime Final Approved!');
    }

    // Fungsi untuk menampilkan halaman Preview (Web View)
    public function preview($id)
    {
        $user = auth()->user();
        $spl = Spl::with(['details.user', 'creator'])->findOrFail($id);

        // Proteksi akses sesuai role
        $this->checkAccess($spl, $user); 

        return view('spl.preview', compact('spl'));
    }

    // Fungsi internal untuk cek akses (agar kode tidak berulang)
    private function checkAccess($spl, $user) {
        if ($user->role == 'Karyawan') {
            if (!$spl->details->where('user_id', $user->id)->count()) abort(403);
        } elseif ($user->role == 'Supervisor' && $spl->created_by != $user->id) {
            abort(403);
        } elseif ($user->role == 'Manager' && $spl->creator->department != $user->department) {
            abort(403);
        }
    }
    
    // -- Fungsi Surat PDF --
    public function downloadPdf($id)
    {
        $user = auth()->user();
        // Mengambil data SPL beserta detail dan usernya
        $spl = Spl::with(['details.user', 'creator'])->findOrFail($id);

        // Cari Manager yang berasal dari departemen yang sama dengan pembuat SPL
        $manager = \App\Models\User::where('role', 'Manager')
                    ->where('department', $spl->creator->department)
                    ->first();
        $adminSdm = \App\Models\User::where('role', 'Admin SDM')->first();
        
        // LOGIKA KEAMANAN AKSES
        if ($user->role == 'Karyawan') {
            // Karyawan hanya bisa melihat jika namanya ada di dalam detail surat tersebut
            $isMySpl = $spl->details->where('user_id', $user->id)->first();
            if (!$isMySpl) abort(403, 'Anda tidak memiliki akses ke surat ini.');
        } elseif ($user->role == 'Supervisor') {
            // SPV hanya bisa melihat surat yang dia buat sendiri
            if ($spl->created_by != $user->id) abort(403);
        } elseif ($user->role == 'Manager') {
            // Manager hanya melihat departemennya
            if ($spl->creator->department != $user->department) abort(403);
        }
        // Admin SDM otomatis memiliki akses ke semua data

        $pdf = Pdf::loadView('overtime.pdf_template', compact('spl', 'manager', 'adminSdm'));
        return $pdf->stream('overtime-' . $spl->no_spl . '.pdf');
    }
}
