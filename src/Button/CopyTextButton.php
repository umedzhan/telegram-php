<?php

namespace Telegram\Bot\Button;

class CopyTextButton
{
    public function __construct(public string $text)
    {
    }

    public function toArray(): array
    {
        return ['text' => $this->text];
    }
}
