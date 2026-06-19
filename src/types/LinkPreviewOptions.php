<?php

namespace Telegram\Bot\Types;

class LinkPreviewOptions
{
    public function __construct(
        public ?bool $is_disabled,
        public ?string $url,
        public ?bool $prefer_small_media,
        public ?bool $prefer_large_media,
        public ?bool $show_above_text
    ) {
        $this->is_disabled = $is_disabled;
        $this->url = $url;
        $this->prefer_small_media = $prefer_small_media;
        $this->prefer_large_media = $prefer_large_media;
        $this->show_above_text = $show_above_text;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            is_disabled: $data['is_disabled'],
        );
    }
}
