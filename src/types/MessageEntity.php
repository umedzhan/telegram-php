<?php

namespace Telegram\Bot\Types;

class MessageEntity
{
    public function __construct(
        public string $type,
        public int $offset,
        public int $length,
        public ?string $url = null,
        public ?array $user = null,
        public ?string $language = null,
        public ?string $custom_emoji_id = null,
        public ?int $unix_time = null,
        public ?string $date_time_format = null
    ) {
    }

    public function toArray(): array
    {
        return array_filter([
            'type' => $this->type,
            'offset' => $this->offset,
            'length' => $this->length,
            'url' => $this->url,
            'user' => $this->user,
            'language' => $this->language,
            'custom_emoji_id' => $this->custom_emoji_id,
            'unix_time' => $this->unix_time,
            'date_time_format' => $this->date_time_format
        ]);
    }
}
