<?php

namespace App\Models;

use App\Traits\UseSystemScope;
use App\Traits\UseUserAndSystemScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TravelOrder extends Model
{
    use HasFactory, SoftDeletes, UseUserAndSystemScope;

    protected $fillable = [
        'user_id',
        'system_id',
        'travel_order_status_id',
        'destination',
        'departure_date',
        'return_date',
    ];

    protected $casts = [
        'departure_date' => 'date',
        'return_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function system(): BelongsTo
    {
        return $this->belongsTo(System::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(TravelOrderStatus::class, 'travel_order_status_id');
    }
}
