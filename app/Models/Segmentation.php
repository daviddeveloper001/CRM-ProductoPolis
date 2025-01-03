<?php

namespace App\Models;

use App\Models\Campaign;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Segmentation extends Model
{
    use HasFactory;


    protected $table = 'segmentations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'block_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'campaign_id' => 'integer',
    ];

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }


    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'segment_registers', 'segment_id', 'customer_id')
            ->withTimestamps(); // Indica una relación many-to-many
    }

    /* public function registers()
    {
        return $this->hasMany(SegmentRegister::class);
    } */

    public function registers()
    {
        return $this->hasMany(CustomerSegment::class);
    }

    public function block(): BelongsTo
    {
        return $this->belongsTo(Block::class); 
    }
}
