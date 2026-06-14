<?php

namespace Telegram\Bot\Types;

class SuggestedPostPrice
{
    public function __construct(
        public string $currency,
        public int $amount
    ) {
    }

    public function toArray(): array
    {
        return [
            'currency' => $this->currency,
            'amount' => $this->amount
        ];
    }
}
