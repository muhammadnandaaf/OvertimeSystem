<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spl extends Model
{
    protected $fillable = ['no_spl', 'tanggal', 'jenis_lembur', 'status_approval', 'created_by'];

    // Relasi ke detail (karyawan yang lembur)
    public function details() {
        return $this->hasMany(SplDetail::class);
    }

    // Relasi ke pembuat (SPV/Manager)
    public function creator() {
        return $this->belongsTo(User::class, 'created_by');
    }
}
