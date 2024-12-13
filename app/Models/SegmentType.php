<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SegmentType extends Model
{
    protected $fillable = ['name'];

    public function sales() : HasMany
    {
        return $this->hasMany(Sale::class);
    }
}
