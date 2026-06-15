# Китобхона барои Телеграм Бот

```bash
composer require umedzhan/telegram-php
```

## Ба коргар паём додан

```php
<?php

require_once 'vendor/autoload.php';

use Telegram\Bot\Telegram;

$telegram = new Telegram('ТОКЕНИ_БОТИ_ТЕЛЕГРАМ');

$telegram->sendMessage(123456778, 'Салом дунё');
```

## Аз корбар паём гирифтан

```php
<?php

require_once 'vendor/autoload.php';

use Telegram\Bot\Telegram;

$telegram = new Telegram('ТОКЕНИ_БОТИ_ТЕЛЕГРАМ');

if ($telegram->isMessage()) {

    $chat_id = $telegram->ChatID();
    $text = $telegram->Text();

    if ($text == '/start') {
        $telegram->sendMessage($chat_id, 'Салом хуш омадед!');
    }
}
```

## Эҷоди тугмаҳо

```php
<?php

use Telegram\Bot\Keyboard;

$keyboard = new ReplyKeyboardMarkup(
    [
        [
            new KeyboardButton('Якум'),
            new KeyboardButton('Дуюм'),
        ],
        [
            new KeyboardButton('Сеюм'),
        ]
    ]
);

$telegram->sendMessage($chat_id, 'Тугмаҳо', reply_markup: $keyboard);
```
