<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Excavator extends Model
{
    use HasFactory;
    public $table = 'excavator';
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
