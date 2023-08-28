<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forklift extends Model
{
    use HasFactory;

    public $table = 'forklift';
    protected $fillable = [
        'no_order',
        'pekerjaan',
        'kapal',
        'no_palka',
        'kegiatan',
        'area',
        'time_start',
        'time_end',
        'status',
        'Approved_time'
    ];
}
