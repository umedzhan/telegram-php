<?php

namespace Telegram\Bot\Keyboard;

use Telegram\Bot\Keyboard\KeyboardButton;
use Telegram\Bot\Interfaces\ReplyMarkup;
use Override;

class ReplyKeyboardMarkup implements ReplyMarkup
{
    public function __construct(
        public array $keyboard,
        public ?bool $is_persistent = null,
        public ?bool $resize_keyboard = null,
        public ?bool $one_time_keyboard = null,
        public ?string $input_field_placeholder = null,
        public ?bool $selective = null
    ) {
    }

    #[Override]
    public function toArray(): array
    {
        $keyboard = [];

        foreach ($this->keyboard as $row) {
            $buttons = [];

            foreach ($row as $button) {
                $buttons[] = $button->toArray();
            }

            $keyboard[] = $buttons;
        }

        return array_filter([
            'keyboard' => $keyboard,
            'is_persistent' => $this->is_persistent,
            'resize_keyboard' => $this->resize_keyboard,
            'one_time_keyboard' => $this->one_time_keyboard,
            'input_field_placeholder' => $this->input_field_placeholder,
            'selective' => $this->selective,
        ], fn ($v) => $v !== null);
    }

}
