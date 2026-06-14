<?php

interface ReplyMarkup
{
    public function toArray(): array;
}

interface InputFile
{
    public function toArray(): array;
}

class Telegram
{
    public array $update = [];

    public function __construct(private string $token)
    {
        $this->token = $token;
        $this->update = json_decode(file_get_contents('php://input'), true) ?? []   ;
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
        InputFile|string $document,
        ?string $business_connection_id = null,
        ?int $message_thread_id = null,
        ?int $direct_messages_topic_id = null,
        InputFile|string|null $thumbnail = null,
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
                    'thumbnail' => $thumbnail instanceof InputFile
                        ? $thumbnail->toArray()
                        : $thumbnail,
                    'caption' => $caption,
                    'parse_mode' => $parse_mode,
                    'caption_entities' => $caption_entities?->toArray(),
                    'disable_content_type_detection' => $disable_content_type_detection,
                    'disable_notification' => $disable_notification,
                    'protect_content' => $protect_content,
                    'allow_paid_broadcast' => $allow_paid_broadcast,
                    'message_effect_id' => $message_effect_id,
                    'suggested_post_parameters' => $suggested_post_parameters?->toArray(),
                    'reply_parameters' => $reply_parameters?->toArray(),
                    'reply_markup' => $reply_markup?->toArray()
                ]
            )
        );
    }
}

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

class SuggestedPostParameters
{
    public function __construct(
        public ?SuggestedPostPrice $price = null,
        public ?int $send_date = null
    ) {
    }

    public function toArray(): array
    {
        return array_filter([
            'price' => $this->price?->toArray(),
            'send_date' => $this->send_date
        ]);
    }
}

class SuggestedPostPrice
{
    public function __construct(
        public string $currency,
        public int $amount
    ) {
    }

    public function toArray(): array
    {
        return [
            'currency' => $this->currency,
            'amount' => $this->amount
        ];
    }
}

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

class InlineKeyboardMarkup implements ReplyMarkup
{
    public function __construct(public array $inline_keyboard)
    {
        $this->inline_keyboard = $inline_keyboard;
    }

    #[Override]
    public function toArray(): array
    {
        $keyboard = [];

        foreach ($this->inline_keyboard as $row) {
            $buttons = [];

            foreach ($row as $button) {
                if (!$button instanceof InlineKeyboardButton) {
                    throw new InvalidArgumentException(
                        'inline_keyboard must contain only InlineKeyboardButton objects'
                    );
                }

                $buttons[] = $button->toArray();
            }

            $keyboard[] = $buttons;
        }

        return [
            'inline_keyboard' => $keyboard
        ];
    }
}

class InlineKeyboardButton
{
    public function __construct(
        public string $text,
        public ?string $icon_custom_emoji_id = null,
        public ?string $style = null,
        public ?string $url = null,
        public ?string $callback_data = null,
        public ?WebAppInfo $web_app = null,
        public ?LoginUrl $login_url = null,
        public ?string $switch_inline_query = null,
        public ?string $switch_inline_query_current_chat = null,
        public ?string $switch_inline_query_chosen_chat = null,
        public ?CopyTextButton $copy_text = null,
        public ?string $callback_game = null,
        public ?string $pay = null
    ) {
    }

    public function toArray(): array
    {
        return array_filter(
            [
                'text' => $this->text,
                'icon_custom_emoji_id' => $this->icon_custom_emoji_id,
                'style' => $this->style,
                'url' => $this->url,
                'callback_data' => $this->callback_data,
                'web_app' => $this->web_app?->toArray(),
                'login_url' => $this->login_url?->toArray(),
                'switch_inline_query' => $this->switch_inline_query,
                'switch_inline_query_current_chat' => $this->switch_inline_query_current_chat,
                'switch_inline_query_chosen_chat' => $this->switch_inline_query_chosen_chat,
                'copy_text' => $this->copy_text?->toArray(),
                'callback_game' => $this->callback_game,
                'pay' => $this->pay
            ]
        );
    }
}

class ReplyKeyboardMarkup implements ReplyMarkup
{
    public function __construct(
        public array $keyboard,
        public ?bool $is_persistent = null,
        public ?bool $resize_keyboard = null,
        public ?bool $one_time_keyboard = null,
        public ?string $input_field_placeholder = null,
        public ?bool $selective = null
    ) {
    }

    #[Override]
    public function toArray(): array
    {
        $keyboard = [];

        foreach ($this->keyboard as $row) {
            $buttons = [];

            foreach ($row as $button) {
                $buttons[] = $button->toArray();
            }

            $keyboard[] = $buttons;
        }

        return array_filter([
            'keyboard' => $keyboard,
            'is_persistent' => $this->is_persistent,
            'resize_keyboard' => $this->resize_keyboard,
            'one_time_keyboard' => $this->one_time_keyboard,
            'input_field_placeholder' => $this->input_field_placeholder,
            'selective' => $this->selective,
        ], fn ($v) => $v !== null);
    }

}

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

class KeyboardButtonRequestUsers
{
    public function __construct(
        public int $request_id,
        public ?bool $user_is_bot = null,
        public ?bool $user_is_premium = null,
        public ?int $max_quantity = null,
        public ?bool $request_name = null,
        public ?bool $request_username = null,
        public ?bool $request_photo = null
    ) {
    }

    public function toArray(): array
    {
        return array_filter(
            [
                'request_id' => $this->request_id,
                'user_is_bot' => $this->user_is_bot,
                'user_is_premium' => $this->user_is_premium,
                'max_quantity' => $this->max_quantity,
                'request_name' => $this->request_name,
                'request_username' => $this->request_username,
                'request_photo' => $this->request_photo
            ]
        );
    }
}

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

class KeyboardButtonRequestManagedBot
{
    public function __construct(
        public int $request_id,
        public ?string $suggested_name = null,
        public ?string $suggested_username = null
    ) {
    }

    public function toArray(): array
    {
        return array_filter(
            [
                'request_id' => $this->request_id,
                'suggested_name' => $this->suggested_name,
                'suggested_username' => $this->suggested_username
            ]
        );
    }
}

class KeyboardButtonPollType
{
    public function __construct(public ?string $type = null)
    {
    }

    public function toArray(): ?array
    {
        return $this->type ? ['type' => $this->type] : null;
    }
}

class WebAppInfo
{
    public function __construct(public string $url)
    {
    }

    public function toArray(): array
    {
        return ['url' => $this->url];
    }
}

class LoginUrl
{
    public function __construct(
        public string $url,
        public ?string $forward_text = null,
        public ?string $bot_username = null,
        public ?bool $request_write_access = null
    ) {
    }

    public function toArray(): array
    {
        return array_filter(
            [
                'url' => $this->url,
                'forward_text' => $this->forward_text,
                'bot_username' => $this->bot_username,
                'request_write_access' => $this->request_write_access
            ]
        );
    }
}

class CopyTextButton
{
    public function __construct(public string $text)
    {
    }

    public function toArray(): array
    {
        return ['text' => $this->text];
    }
}

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
