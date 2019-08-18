# telegramWhereToEatBot
Telegram Bot automatically sets up a poll everyday so users in a group can vote for a place to eat lunch.

## Usage
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
