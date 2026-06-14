<?php

namespace Telegram\Bot\Button;

class LoginUrl
{
    public function __construct(
        public string $url,
        public ?string $forward_text = null,
        public ?string $bot_username = null,
        public ?bool $request_write_access = null
    ) {
    }

    public function toArray(): array
    {
        return array_filter(
            [
                'url' => $this->url,
                'forward_text' => $this->forward_text,
                'bot_username' => $this->bot_username,
                'request_write_access' => $this->request_write_access
            ]
        );
    }
}
