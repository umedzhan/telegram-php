<?php

namespace Telegram\Bot\Button;

class KeyboardButtonRequestManagedBot
{
    public function __construct(
        public int $request_id,
        public ?string $suggested_name = null,
        public ?string $suggested_username = null
    ) {
    }

    public function toArray(): array
    {
        return array_filter(
            [
                'request_id' => $this->request_id,
                'suggested_name' => $this->suggested_name,
                'suggested_username' => $this->suggested_username
            ]
        );
    }
}
