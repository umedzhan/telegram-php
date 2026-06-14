<?php

namespace Telegram\Bot\Keyboard;

use Telegram\Bot\Button\WebAppInfo;
use Telegram\Bot\Button\KeyboardButtonRequestChat;
use Telegram\Bot\Button\KeyboardButtonRequestManagedBot;
use Telegram\Bot\Button\KeyboardButtonRequestUsers;
use Telegram\Bot\Button\KeyboardButtonPollType;

class KeyboardButton
{
    public function __construct(
        public string $text,
        public ?string $icon_custom_emoji_id = null,
        public ?string $style = null,
        public ?KeyboardButtonRequestUsers $request_users = null,
        public ?KeyboardButtonRequestChat $request_chat = null,
        public ?KeyboardButtonRequestManagedBot $request_managed_bot = null,
        public ?bool $request_contact = null,
        public ?bool $request_location = null,
        public ?KeyboardButtonPollType $request_poll = null,
        public ?WebAppInfo $web_app = null
    ) {
    }

    public function toArray(): array
    {
        return array_filter([
            'text' => $this->text,
            'icon_custom_emoji_id' => $this->icon_custom_emoji_id,
            'style' => $this->style,
            'request_users' => $this->request_users?->toArray(),
            'request_chat' => $this->request_chat?->toArray(),
            'request_managed_bot' => $this->request_managed_bot?->toArray(),
            'request_contact' => $this->request_contact,
            'request_location' => $this->request_location,
            'request_poll' => $this->request_poll?->toArray(),
            'web_app' => $this->web_app?->toArray()
        ]);
    }
}
