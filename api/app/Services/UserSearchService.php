<?php

namespace App\Services;

use App\Services\Service;
use Illuminate\Database\Eloquent\Builder;

class UserSearchService extends Service
{
    public static function search(array $filters, Builder $query)
    {
        self::applyIfInArray($filters, 'search', function (string $search) use ($query) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        });

        return $query;
    }
}
