<?php

namespace App\Models\Enums;

class PirepState extends EnumBase {

    public const REJECTED      = -1;
    public const IN_PROGRESS   = 0;  // flight is ongoing
    public const PENDING       = 1;  // waiting admin approval
    public const ACCEPTED      = 2;
    public const CANCELLED     = 3;
    public const DELETED       = 4;

    protected static $labels = [
        PirepState::REJECTED      => 'system.pireps.state.rejected',
        PirepState::IN_PROGRESS   => 'system.pireps.state.in_progress',
        PirepState::PENDING       => 'system.pireps.state.pending',
        PirepState::ACCEPTED      => 'system.pireps.state.accepted',
        PirepState::CANCELLED     => 'system.pireps.state.cancelled',
        PirepState::DELETED       => 'system.pireps.state.deleted',
    ];
}
