<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alber extends Model
{
    use HasFactory;
    protected $fillable = [
        'jenis_alber',
        'no_order',
        'pekerjaan',
        'kapal',
        'no_palka',
        'kegiatan',
        'area',
        'time_start',
        'time_end',
        'status',
        'status_time',
        'no_lambung',
        'operator',
        'requested_by'
    ];
}
