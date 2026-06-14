<?php

namespace Telegram\Bot\Types;

use Telegram\Bot\Types\MessageEntity;

class ReplyParameters
{
    public function __construct(
        public int $message_id,
        public int|string|null $chat_id = null,
        public ?bool $allow_sending_without_reply = null,
        public ?string $quote = null,
        public ?string $quote_parse_mode = null,
        public ?MessageEntity $quote_entities = null,
        public ?int $quote_position = null,
        public ?int $checklist_task_id = null,
        public ?string $poll_option_id = null
    ) {
    }

    public function toArray(): array
    {
        return array_filter([
            'message_id' => $this->message_id,
            'chat_id' => $this->chat_id,
            'allow_sending_without_reply' => $this->allow_sending_without_reply,
            'quote' => $this->quote,
            'quote_parse_mode' => $this->quote_parse_mode,
            'quote_entities' => $this->quote_entities?->toArray(),
            'quote_position' => $this->quote_position,
            'checklist_task_id' => $this->checklist_task_id,
            'poll_option_id' => $this->poll_option_id
        ]);
    }
}
