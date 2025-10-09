<?php

namespace App\Enum;

enum RoomQueueStatus: string
{
    case WAITING = 'waiting';
    case COMPLETED = 'completed';

    public static function toArray(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }

    public static function allIntoString(): string
    {
        return implode(',', self::toArray());
    }
}
