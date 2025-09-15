<?php

namespace App\Enums;

enum Servicio: string
{
    case A = 'Organización de eventos/Marketing';
    case Marketing = 'Marketing';
    case Organizacion = 'Organización de eventos';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function options(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}