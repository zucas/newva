<?php
/**
 * Enums for PIREP statuses
 */

namespace App\Models\Enums;

/**
 * Tied to the ACARS statuses/states
 * Class PirepStatus
 * @package App\Models\Enums
 */
class PirepStatus extends EnumBase
{
    public const PREFILE       = 0;
    public const SCHEDULED     = 0;
    public const ENROUTE       = 1;
    public const ARRIVED       = 2;

    protected static $labels = [
        PirepStatus::PREFILE    => 'Prefiled',
        PirepStatus::SCHEDULED  => 'Scheduled',
        PirepStatus::ENROUTE    => 'Enroute',
        PirepStatus::ARRIVED    => 'Arrived',
    ];
}
