<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KjfdQuota extends Model
{
    use HasFactory;

    protected $table = 'kjfd_quotas';

    protected $fillable = [
        'bidang',
        'quota',
    ];
}
