<?php

namespace App\Enum;

class InfantEnum
{
    public const MONTHS_TO_BECOME_INFANT = 2;

    public static function getIntervalToBecomeInfant(): string
    {
        return sprintf('-%d month', self::MONTHS_TO_BECOME_INFANT);
    }
}