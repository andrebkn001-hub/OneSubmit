<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'nim',
        'judul_proposal',
        'bidang_minat',
        'file_proposal',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
