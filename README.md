# telegramWhereToEatBot
Telegram Bot automatically sets up a poll everyday so users in a group can vote for a place to eat lunch.

## Usage
```
# src/config.php
<?php
define('BOT_TOKEN', 'XXXXXXXXX:XXXX-XXXXXXXXXXXXXXXX_XXXXXXXXXXXXX');
define('BOT_WEBHOOK', 'https://XXXX/src/poll-bot-webhook.php');
define('CHAT_ID', XXXX);
define('FROM_ID', XXXX);
define('FROM_FIRST_NAME', 'patrick');
define('CHAT_TITLE', 'WhereToEat Group');
```
```
sudo php poll-bot-webhook.php set
sudo php poll-bot-webhook.php remove
```
```
sudo php poll-bot-webhook.php /endpoll
```
```
sudo php poll-bot-webhook.php /newpoll
```

## Specification
- see https://github.com/kolar/telegram-poll-bot
- Entrypoint: poll-bot-webhook.php
- User is not allowed to send /newpoll, /endpoll
