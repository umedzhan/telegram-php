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

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            type: $data['type'],
            title: $data['title'] ?? null,
            username: $data['username'] ?? null,
            first_name: $data['first_name'] ?? null,
            last_name: $data['last_name'] ?? null,
            is_forum: $data['is_forum'] ?? null,
            is_direct_messages: $data['is_direct_messages'] ?? null
        );
    }
}
