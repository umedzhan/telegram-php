<?php

namespace Telegram\Bot\Keyboard;

use Telegram\Bot\Button\WebAppInfo;
use Telegram\Bot\Button\LoginUrl;
use Telegram\Bot\Button\CopyTextButton;

class InlineKeyboardButton
{
    public function __construct(
        public string $text,
        public ?string $icon_custom_emoji_id = null,
        public ?string $style = null,
        public ?string $url = null,
        public ?string $callback_data = null,
        public ?WebAppInfo $web_app = null,
        public ?LoginUrl $login_url = null,
        public ?string $switch_inline_query = null,
        public ?string $switch_inline_query_current_chat = null,
        public ?string $switch_inline_query_chosen_chat = null,
        public ?CopyTextButton $copy_text = null,
        public ?string $callback_game = null,
        public ?string $pay = null
    ) {
    }

    public function toArray(): array
    {
        return array_filter(
            [
                'text' => $this->text,
                'icon_custom_emoji_id' => $this->icon_custom_emoji_id,
                'style' => $this->style,
                'url' => $this->url,
                'callback_data' => $this->callback_data,
                'web_app' => $this->web_app?->toArray(),
                'login_url' => $this->login_url?->toArray(),
                'switch_inline_query' => $this->switch_inline_query,
                'switch_inline_query_current_chat' => $this->switch_inline_query_current_chat,
                'switch_inline_query_chosen_chat' => $this->switch_inline_query_chosen_chat,
                'copy_text' => $this->copy_text?->toArray(),
                'callback_game' => $this->callback_game,
                'pay' => $this->pay
            ]
        );
    }
}
