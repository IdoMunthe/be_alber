<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WheelLoader extends Model
{
    use HasFactory;
    public $table = 'wheel_loader';
    protected $fillable = [
        'no_order',
        'pekerjaan',
        'kapal',
        'no_palka',
        'kegiatan',
        'area'
    ];
}
