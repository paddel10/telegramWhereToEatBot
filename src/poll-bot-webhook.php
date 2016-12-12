<?php

require_once 'PollBot.php';
require_once 'config.php';
require_once 'injectMessage.php';

$bot = new PollBot(BOT_TOKEN, 'PollBotChat');
$updates = array();

if (php_sapi_name() == 'cli') {
  if ($argv[1] == 'set') {
    $bot->setWebhook(BOT_WEBHOOK);
    exit;
  } else if ($argv[1] == 'remove') {
    $bot->removeWebhook();
    exit;
  } else if ($argv[1] == '/newpoll') {
    $messages = array($argv[1], "Wo essen? (Abstimmung endet um 10:00)", "Linde", "Weinberg", "Büro", "andere", "/done");
    foreach ($messages as $message) {
      array_push($updates, generateMessage(CHAT_ID, $message, FROM_ID, FROM_FIRST_NAME, CHAT_TITLE));
    }
  } else if ($argv[1] == '/endpoll') {
    array_push($updates, generateMessage(CHAT_ID, $argv[1], FROM_ID, FROM_FIRST_NAME, CHAT_TITLE));
  }
} else {
  $response = file_get_contents('php://input');
  $update = json_decode($response, true);
  if ($update['message']['text'] != "/newpoll" ||
      $update['message']['text'] != "/endpoll") {
    array_push($updates, $update);
  }
}

$bot->init();
foreach ($updates as $update) {
  $bot->onUpdateReceived($update);
  sleep(2);
}
