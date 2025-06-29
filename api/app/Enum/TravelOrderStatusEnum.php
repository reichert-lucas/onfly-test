<?php

namespace App\Enum;

enum TravelOrderStatusEnum: int
{
    case REQUESTED = 1;
    case APPROVED = 2;
    case CANCELLED = 3;

    public function label(): string 
    {
        return match ($this) {
            self::REQUESTED => 'Solicitado',
            self::APPROVED => 'Aprovado',
            self::CANCELLED => 'Cancelado',
        };
    }

    public function color(): string 
    {
        return match ($this) {
            self::REQUESTED => '#FFA500',
            self::APPROVED => '#28A745',
            self::CANCELLED => '#DC3545',
        };
    }
}
