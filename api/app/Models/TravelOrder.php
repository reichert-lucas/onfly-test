<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use App\Services\TravelOrder\SearchService;
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

    public function system(): BelongsTo
    {
        return $this->belongsTo(System::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(TravelOrderStatus::class, 'travel_order_status_id');
    }

    static public function search(array $filters): Builder
    {
        $query = self::query();

        SearchService::search($filters, $query);

        return $query;
    }
}
