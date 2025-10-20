<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'judul',
        'file_path',
        'status',
    ];

    // Relasi: satu pengajuan dimiliki oleh satu user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}