<?php

namespace Telegram\Bot\Button;

class KeyboardButtonRequestChat
{
    public function __construct(
        public int $request_id,
        public bool $chat_is_channel,
        public ?bool $chat_is_forum = null,
        public ?bool $chat_has_username = null,
        public ?bool $chat_is_created = null,
        public ?string $user_administrator_rights = null,
        public ?string $bot_administrator_rights = null,
        public ?bool $bot_is_member = null,
        public ?bool $request_title = null,
        public ?bool $request_username = null,
        public ?bool $request_photo = null
    ) {
    }

    public function toArray(): array
    {
        return array_filter(
            [
                'request_id' => $this->request_id,
                'chat_is_channel' => $this->chat_is_channel,
                'chat_is_forum' => $this->chat_is_forum,
                'chat_has_username' => $this->chat_has_username,
                'chat_is_created' => $this->chat_is_created,
                'user_administrator_rights' => $this->user_administrator_rights,
                'bot_administrator_rights' => $this->bot_administrator_rights,
                'bot_is_member' => $this->bot_is_member,
                'request_title' => $this->request_title,
                'request_username' => $this->request_username,
                'request_photo' => $this->request_photo
            ]
        );
    }
}
