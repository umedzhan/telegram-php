<?php

namespace Telegram\Bot\Button;

class WebAppInfo
{
    public function __construct(public string $url)
    {
    }

    public function toArray(): array
    {
        return ['url' => $this->url];
    }
}
