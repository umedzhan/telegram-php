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

    public function toArray(): array
    {
        return array_filter(
            [
                'is_disabled' => $this->is_disabled,
                'url' => $this->url,
                'prefer_small_media' => $this->prefer_small_media,
                'prefer_large_media' => $this->prefer_large_media,
                'show_above_text' => $this->show_above_text
            ]
        );
    }
}
