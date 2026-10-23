<?php

namespace App\Actions;

use App\Enums\ChargeStatus;

class ChargeResult
{
    /**
     * @param  string|null  $message  Pin's reason, when the charge was declined
     */
    public function __construct(
        public readonly ChargeStatus $status,
        public readonly ?string $message = null,
    ) {
    }
}
