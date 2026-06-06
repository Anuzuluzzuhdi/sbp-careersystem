<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalysisHistory extends Model
{
    use HasFactory;

    // Izinkan kolom ini diisi data
    protected $fillable = ['user_id', 'criteria', 'results'];

    // Ubah format json dari database jadi array otomatis biar gampang dibaca
    protected $casts = [
        'criteria' => 'array',
        'results' => 'array',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}