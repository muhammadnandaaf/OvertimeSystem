<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SplDetail extends Model
{
    // Mengizinkan kolom ini diisi secara massal
    protected $fillable = [
        'spl_id', 
        'user_id', 
        'jam_mulai', 
        'jam_selesai', 
        'total_jam', 
        'total_konversi', 
        'alasan_verifikasi', 
        'is_verified'
    ];

    // Relasi ke tabel User (Karyawan)
    public function spl(): BelongsTo
    {
        return $this->belongsTo(Spl::class, 'spl_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function hitungKonversi($jenisLembur, $totalJam){
        $konversi = 0;

        if ($totalJam <= 0) return 0;

        if ($jenisLembur == 'Reguler') {
            // Aturan: 1 jam pertama x 1.5, sisanya x 2 [cite: 37, 38, 39]
            if ($totalJam <= 1) {
                $konversi = $totalJam * 1.5;
            } else {
                $konversi = (1 * 1.5) + (($totalJam - 1) * 2);
            }
        } else if ($jenisLembur == 'Off') {
            // Aturan: Dipotong 1 jam istirahat, jam 1-7 x 2, jam 8 x 3, jam 9+ x 4 [cite: 40, 41, 42, 43, 44]
            $jamBersih = max(0, $totalJam - 1); // Potong istirahat [cite: 44]
            
            if ($jamBersih <= 7) {
                $konversi = $jamBersih * 2;
            } elseif ($jamBersih == 8) {
                $konversi = (7 * 2) + (1 * 3);
            } else {
                $konversi = (7 * 2) + (1 * 3) + (($jamBersih - 8) * 4);
            }
        }

        return $konversi;
    }
}
