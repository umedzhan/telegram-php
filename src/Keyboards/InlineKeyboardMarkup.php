<?php

namespace Telegram\Bot\Keyboard;

use Telegram\Bot\Interfaces\ReplyMarkup;
use Telegram\Bot\Keyboard\InlineKeyboardButton;
use InvalidArgumentException;
use Override;

class InlineKeyboardMarkup implements ReplyMarkup
{
    public function __construct(public array $inline_keyboard)
    {
        $this->inline_keyboard = $inline_keyboard;
    }

    #[Override]
    public function toArray(): array
    {
        $keyboard = [];

        foreach ($this->inline_keyboard as $row) {
            $buttons = [];

            foreach ($row as $button) {
                if (!$button instanceof InlineKeyboardButton) {
                    throw new InvalidArgumentException(
                        'inline_keyboard must contain only InlineKeyboardButton objects'
                    );
                }

                $buttons[] = $button->toArray();
            }

            $keyboard[] = $buttons;
        }

        return [
            'inline_keyboard' => $keyboard
        ];
    }
}
