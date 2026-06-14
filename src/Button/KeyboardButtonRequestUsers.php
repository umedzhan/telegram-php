<?php

namespace Telegram\Bot\Button;

class KeyboardButtonRequestUsers
{
    public function __construct(
        public int $request_id,
        public ?bool $user_is_bot = null,
        public ?bool $user_is_premium = null,
        public ?int $max_quantity = null,
        public ?bool $request_name = null,
        public ?bool $request_username = null,
        public ?bool $request_photo = null
    ) {
    }

    public function toArray(): array
    {
        return array_filter(
            [
                'request_id' => $this->request_id,
                'user_is_bot' => $this->user_is_bot,
                'user_is_premium' => $this->user_is_premium,
                'max_quantity' => $this->max_quantity,
                'request_name' => $this->request_name,
                'request_username' => $this->request_username,
                'request_photo' => $this->request_photo
            ]
        );
    }
}
