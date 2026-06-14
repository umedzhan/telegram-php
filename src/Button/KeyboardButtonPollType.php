<?php

namespace Telegram\Bot\Button;

class KeyboardButtonPollType
{
    public function __construct(public ?string $type = null)
    {
    }

    public function toArray(): ?array
    {
        return $this->type ? ['type' => $this->type] : null;
    }
}
