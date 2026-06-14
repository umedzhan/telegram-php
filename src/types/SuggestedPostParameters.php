<?php

namespace Telegram\Bot\Types;

use Telegram\Bot\Types\SuggestedPostPrice;

class SuggestedPostParameters
{
    public function __construct(
        public ?SuggestedPostPrice $price = null,
        public ?int $send_date = null
    ) {
    }

    public function toArray(): array
    {
        return array_filter([
            'price' => $this->price?->toArray(),
            'send_date' => $this->send_date
        ]);
    }
}
