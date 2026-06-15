<?php

namespace Telegram\Bot\Types;

class Chat
{
    public function __construct(
        public int $id,
        public string $type,
        public ?string $title = null,
        public ?string $username = null,
        public ?string $first_name = null,
        public ?string $last_name = null,
        public ?bool $is_forum = null,
        public ?bool $is_direct_messages = null
    ) {
    }

    public function toArray(): array
    {
        return array_filter([
            'id' => $this->id,
            'type' => $this->type,
            'title' => $this->title,
            'username' => $this->username,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'is_forum' => $this->is_forum,
            'is_direct_messages' => $this->is_direct_messages
        ], fn ($v) => $v !== null);
    }
}
