<?php

namespace App\Services\TravelOrder;

use App\Services\Service;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class SearchService extends Service
{
    public static function search(array $filters, Builder $query)
    {
        $query->join('users', 'users.id', '=', 'travel_orders.user_id');

        $query->select('travel_orders.*');

        self::applyIfInArray($filters, 'search', function (string $search) use ($query) {
            $query->where(function ($query) use ($search) {
                $search = strtolower($search);

                $query->whereRaw('LOWER(travel_orders.destination) LIKE ?', ['%' . $search . '%'])
                    ->orWhereRaw('LOWER(users.name) LIKE ?', ['%' . $search . '%'])
                    ->orWhereRaw('LOWER(users.email) LIKE ?', ['%' . $search . '%']);
            });
        });

        self::applyIfInArray($filters, 'status_id', function (int $statusId) use ($query) {
           $query->where('travel_orders.travel_order_status_id', $statusId); 
        });

        self::applyIfInArray($filters, 'departure_date', function (string $departureDate) use ($query) {
            $query->whereDate('travel_orders.departure_date', '<=', $departureDate);
        });

        self::applyIfInArray($filters, 'return_date', function (string $returnDate) use ($query) {
            $query->whereDate('travel_orders.return_date', '>=', $returnDate); 
        });

        $query->orderBy('travel_orders.updated_at', 'desc');

        return $query;
    }
}
