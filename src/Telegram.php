<?php

use Telegram\Bot\Interfaces\ReplyMarkup;
use Telegram\Bot\Types\LinkPreviewOptions;
use Telegram\Bot\Types\InputRichMessage;
use Telegram\Bot\Types\MessageEntity;
use Telegram\Bot\Types\SuggestedPostParameters;
use Telegram\Bot\Types\ReplyParameters;

class Telegram
{
    public array $update = [];

    public function __construct(private string $token)
    {
        $this->token = $token;
        $this->update = json_decode(file_get_contents('php://input'), true) ?? [];
    }

    public function bot(string $method, $data = [])
    {
        $token = $this->token;
        $url = "https://api.telegram.org/bot$token/$method";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $response = curl_exec($ch);
        return json_decode($response, true);
    }

    public function token()
    {
        return $this->token;
    }

    public function ChatID()
    {
        if ($this->isMessage()) {
            return $this->update['message']['from']['id'];
        } elseif ($this->isQuery()) {
            return $this->update['callback_query']['from']['id'];
        } elseif ($this->isBusinessMessage()) {
            return $this->update['business_message']['chat']['id'];
        }
        return null;
    }

    public function messageID()
    {
        if ($this->isBusinessMessage()) {
            return $this->update['business_message']['message_id'];
        }
    }

    public function BusinessConnectionID()
    {
        if ($this->isBusinessMessage()) {
            return $this->update['business_message']['business_connection_id'];
        }
    }

    public function Username()
    {
        if ($this->isMessage()) {
            return $this->update['message']['from']['username'] ? $this->update['message']['from']['username'] : null;
        }
    }

    public function isMessage()
    {
        return isset($this->update['message']);
    }

    public function isQuery()
    {
        return isset($this->update['callback_query']);
    }

    public function isBusinessMessage()
    {
        return isset($this->update['business_message']);
    }

    public function isMessageContact()
    {
        return $this->update['message']['contact'] ? true : false;
    }

    public function isChannelPost()
    {
        return $this->update['channel_post'] ? true : false;
    }

    public function Text()
    {
        if ($this->isMessage()) {
            return isset($this->update['message']['text']) ? $this->update['message']['text'] : '';
        } elseif ($this->isQuery()) {
            return isset($this->update['callback_query']['data']) ? $this->update['callback_query']['data'] : '';
        } elseif ($this->isBusinessMessage()) {
            return isset($this->update['business_message']['text']) ? $this->update['business_message']['text'] : '';
        }
    }

    public function FirstName()
    {
        if ($this->isMessage()) {
            return $this->update['message']['chat']['first_name'];
        } elseif ($this->isQuery()) {
            return $this->update['callback_query']['from']['first_name'];
        }
    }

    public function PhoneNumber()
    {
        return $this->update['message']['contact']['phone_number'] ? $this->update['message']['contact']['phone_number'] : '';
    }

    public function sendMessage(
        int|string $chat_id,
        string $text,
        ?string $business_connection_id = null,
        ?int $message_thread_id = null,
        ?int $direct_messages_topic_id = null,
        ?string $parse_mode = null,
        ?array $entities = null,
        ?LinkPreviewOptions $link_preview_options = null,
        ?bool $disable_notification = false,
        ?bool $protect_content = false,
        ?bool $allow_paid_broadcast = false,
        ?string $message_effect_id = null,
        ?string $suggested_post_parameters = null,
        ?string $reply_parameters = null,
        ?ReplyMarkup $reply_markup = null
    ): array {
        return $this->bot(
            'sendMessage',
            array_filter(
                [
                    'chat_id' => $chat_id,
                    'text' => $text,
                    'business_connection_id' => $business_connection_id,
                    'message_thread_id' => $message_thread_id,
                    'direct_messages_topic_id' => $direct_messages_topic_id,
                    'parse_mode' => $parse_mode,
                    'entities' => $entities,
                    'link_preview_options' => $link_preview_options ? json_encode($link_preview_options) : null,
                    'disable_notification' => $disable_notification,
                    'protect_content' => $protect_content,
                    'allow_paid_broadcast' => $allow_paid_broadcast,
                    'message_effect_id' => $message_effect_id,
                    'suggested_post_parameters' => $suggested_post_parameters,
                    'reply_parameters' => $reply_parameters,
                    'reply_markup' => $reply_markup ? json_encode($reply_markup->toArray()) : null
                ]
            )
        );
    }

    public function sendRichMessage(
        int|string $chat_id,
        InputRichMessage $rich_message,
        ?string $business_connection_id = null,
        ?int $message_thread_id = null,
        ?int $direct_messages_topic_id = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
        ?bool $allow_paid_broadcast = null,
        ?string $message_effect_id = null,
        ?string $suggested_post_parameters = null,
        ?string $reply_parameters = null,
        ?ReplyMarkup $reply_markup = null
    ) {
        return $this->bot(
            'sendRichMessage',
            array_filter(
                [
                    'business_connection_id' => $business_connection_id,
                    'chat_id' => $chat_id,
                    'message_thread_id' => $message_thread_id,
                    'direct_messages_topic_id' => $direct_messages_topic_id,
                    'rich_message' => $rich_message ? json_encode($rich_message->toArray()) : null,
                    'disable_notification' => $disable_notification,
                    'protect_content' => $protect_content,
                    'allow_paid_broadcast' => $allow_paid_broadcast,
                    'message_effect_id' => $message_effect_id,
                    'suggested_post_parameters' => $suggested_post_parameters,
                    'reply_parameters' => $reply_parameters,
                    'reply_markup' => $reply_markup
                ]
            )
        );
    }

    public function sendDocument(
        int|string $chat_id,
        CURLFile|string $document,
        ?string $business_connection_id = null,
        ?int $message_thread_id = null,
        ?int $direct_messages_topic_id = null,
        CURLFile|string|null $thumbnail = null,
        ?string $caption = null,
        ?string $parse_mode = null,
        ?MessageEntity $caption_entities = null,
        ?bool $disable_content_type_detection = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
        ?bool $allow_paid_broadcast = null,
        ?string $message_effect_id = null,
        ?SuggestedPostParameters $suggested_post_parameters = null,
        ?ReplyParameters $reply_parameters = null,
        ?ReplyMarkup $reply_markup = null
    ): array {
        return $this->bot(
            'sendDocument',
            array_filter(
                [
                    'chat_id' => $chat_id,
                    'document' => $document,
                    'business_connection_id' => $business_connection_id,
                    'message_thread_id' => $message_thread_id,
                    'direct_messages_topic_id' => $direct_messages_topic_id,
                    'thumbnail' => $thumbnail,
                    'caption' => $caption,
                    'parse_mode' => $parse_mode,
                    'caption_entities' => $caption_entities?->toArray() ? json_encode($caption_entities?->toArray()) : null,
                    'disable_content_type_detection' => $disable_content_type_detection,
                    'disable_notification' => $disable_notification,
                    'protect_content' => $protect_content,
                    'allow_paid_broadcast' => $allow_paid_broadcast,
                    'message_effect_id' => $message_effect_id,
                    'suggested_post_parameters' => $suggested_post_parameters?->toArray()
                        ? json_encode($suggested_post_parameters?->toArray())
                        : null,
                    'reply_parameters' => $reply_parameters?->toArray()
                        ? json_encode($reply_parameters?->toArray())
                        : null,
                    'reply_markup' => $reply_markup?->toArray()
                        ? json_encode($reply_markup?->toArray())
                        : null
                ]
            )
        );
    }

    public function forwardMessage(
        int|string $chat_id,
        int|string $from_chat_id,
        int $message_id,
        ?int $message_thread_id = null,
        ?int $direct_messages_topic_id = null,
        ?int $video_start_timestamp = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
        ?string $message_effect_id = null,
        ?SuggestedPostParameters $suggested_post_parameters = null
    ): array {
        return $this->bot(
            'forwardMessage',
            array_filter([
                'chat_id' => $chat_id,
                'from_chat_id' => $from_chat_id,
                'message_id' => $message_id,
                'message_thread_id' => $message_thread_id,
                'direct_messages_topic_id' => $direct_messages_topic_id,
                'video_start_timestamp' => $video_start_timestamp,
                'disable_notification' => $disable_notification,
                'protect_content' => $protect_content,
                'message_effect_id' => $message_effect_id,
                'suggested_post_parameters' => $suggested_post_parameters?->toArray() ? json_encode($suggested_post_parameters?->toArray()) : null,
            ])
        );
    }

    public function forwardMessages(
        int|string $chat_id,
        int|string $from_chat_id,
        array $message_ids,
        ?int $message_thread_id = null,
        ?int $direct_messages_topic_id = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null
    ): array {
        return $this->bot(
            'forwardMessages',
            array_filter([
                'chat_id' => $chat_id,
                'from_chat_id' => $from_chat_id,
                'message_ids' => $message_ids,
                'message_thread_id' => $message_thread_id,
                'direct_messages_topic_id' => $direct_messages_topic_id,
                'disable_notification' => $disable_notification,
                'protect_content' => $protect_content
            ])
        );
    }

    public function copyMessage(
        int|string $chat_id,
        int|string $from_chat_id,
        int $message_id,
        ?int $message_thread_id = null,
        ?int $direct_messages_topic_id = null,
        ?int $video_start_timestamp = null,
        ?string $caption = null,
        ?string $parse_mode = null,
        ?MessageEntity $caption_entities = null,
        ?bool $show_caption_above_media = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
        ?bool $allow_paid_broadcast = null,
        ?string $message_effect_id = null,
        ?SuggestedPostParameters $suggested_post_parameters = null,
        ?ReplyParameters $reply_parameters = null,
        ?ReplyMarkup $reply_markup = null
    ): array {
        return $this->bot(
            'copyMessage',
            array_filter([
                'chat_id' => $chat_id,
                'from_chat_id' => $from_chat_id,
                'message_id' => $message_id,
                'message_thread_id' => $message_thread_id,
                'direct_messages_topic_id' => $direct_messages_topic_id,
                'video_start_timestamp' => $video_start_timestamp,
                'caption' => $caption,
                'parse_mode' => $parse_mode,
                'caption_entities' => $caption_entities?->toArray(),
                'show_caption_above_media' => $show_caption_above_media,
                'disable_notification' => $disable_notification,
                'protect_content' => $protect_content,
                'allow_paid_broadcast' => $allow_paid_broadcast,
                'message_effect_id' => $message_effect_id,
                'suggested_post_parameters' => $suggested_post_parameters?->toArray(),
                'reply_parameters' => $reply_parameters?->toArray(),
                'reply_markup' => $reply_markup?->toArray() ? json_encode($reply_markup?->toArray()) : null
            ])
        );
    }

    public function copyMessages(
        int|string $chat_id,
        int|string $from_chat_id,
        array $message_ids,
        ?int $message_thread_id = null,
        ?int $direct_messages_topic_id = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
        ?bool $remove_caption = null
    ): array {
        return $this->bot(
            'copyMessages',
            array_filter([
                'chat_id' => $chat_id,
                'from_chat_id' => $from_chat_id,
                'message_ids' => $message_ids,
                'message_thread_id' => $message_thread_id,
                'direct_messages_topic_id' => $direct_messages_topic_id,
                'disable_notification' => $disable_notification,
                'protect_content' => $protect_content,
                'remove_caption' => $remove_caption
            ])
        );
    }

    public function sendPhoto(
        int|string $chat_id,
        CURLFile|string $photo,
        ?string $business_connection_id = null,
        ?int $message_thread_id = null,
        ?int $direct_messages_topic_id = null,
        ?string $caption = null,
        ?string $parse_mode = null,
        ?MessageEntity $caption_entities = null,
        ?bool $show_caption_above_media = null,
        ?bool $has_spoiler = null,
        ?bool $disable_notification = null,
        ?bool $protect_content = null,
        ?bool $allow_paid_broadcast = null,
        ?string $message_effect_id = null,
        ?SuggestedPostParameters $suggested_post_parameters = null,
        ?ReplyParameters $reply_parameters = null,
        ?ReplyMarkup $reply_markup = null
    ): array {
        return $this->bot(
            'sendPhoto',
            array_filter([
                'chat_id' => $chat_id,
                'photo' => $photo,
                'business_connection_id' => $business_connection_id,
                'message_thread_id' => $message_thread_id,
                'direct_messages_topic_id' => $direct_messages_topic_id,
                'caption' => $caption,
                'parse_mode' => $parse_mode,
                'caption_entities' => $caption_entities?->toArray() ? json_encode($caption_entities?->toArray()) : null,
                'show_caption_above_media' => $show_caption_above_media,
                'has_spoiler' => $has_spoiler,
                'disable_notification' => $disable_notification,
                'protect_content' => $protect_content,
                'allow_paid_broadcast' => $allow_paid_broadcast,
                'message_effect_id' => $message_effect_id,
                'suggested_post_parameters' => $suggested_post_parameters?->toArray() ? json_encode($suggested_post_parameters?->toArray()) : null,
                'reply_parameters' => $reply_parameters?->toArray() ? json_encode($reply_parameters?->toArray()) : null,
                'reply_markup' => $reply_markup?->toArray() ? json_encode($reply_markup?->toArray()) : null
            ])
        );
    }
}
