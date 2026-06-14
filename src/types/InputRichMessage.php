<?php

namespace Telegram\Bot\Types;

class InputRichMessage
{
    public function __construct(
        public ?string $html = null,
        public ?string $markdown = null,
        public ?bool $is_rtl = null,
        public ?bool $skip_entity_detection = null
    ) {
    }

    public function toArray(): array
    {
        return array_filter(
            [
                'html' => $this->html,
                'markdown' => $this->markdown,
                'is_rtl' => $this->is_rtl,
                'skip_entity_detection' => $this->skip_entity_detection
            ]
        );
    }
}
