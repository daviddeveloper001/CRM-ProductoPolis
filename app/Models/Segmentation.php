<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Segmentation extends Model
{
    protected $fillable = [
        'type',
    ];


    protected $casts = [
        'id' => 'integer',
    ];
}
