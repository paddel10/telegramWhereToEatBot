<?php

require_once 'PollBot.php';
require_once 'config.php';
require_once 'injectMessage.php';

$bot = new PollBot(BOT_TOKEN, 'PollBotChat');

if (php_sapi_name() == 'cli') {
  if ($argv[1] == 'set') {
    $bot->setWebhook(BOT_WEBHOOK);
  } else if ($argv[1] == 'remove') {
    $bot->removeWebhook();
  } else if ($argv[1] == '/newpoll') {
    generateMessage(CHAT_ID, $argv[1], FROM_ID, FROM_FIRST_NAME, CHAT_TITLE);
  }
  exit;
}

$response = file_get_contents('php://input');
$update = json_decode($response, true);

$bot->init();
$bot->onUpdateReceived($update);
