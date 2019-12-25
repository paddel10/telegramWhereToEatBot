<?php

require_once 'PollBot.php';
require_once 'config.php';
require_once 'injectMessage.php';
require_once 'holidays.php';

$bot = new PollBot(BOT_TOKEN, 'PollBotChat');
$updates = array();

if (php_sapi_name() == 'cli') {
  // check for holidays
  $today = date("d.m.Y");
  $tomorrow = date("d.m.Y", strtotime(date("d.m.Y") . ' + 1 day'));
  $holidays = getHolidays();
  
if ($argv[1] == 'set') {
    $bot->setWebhook(BOT_WEBHOOK);
    exit;
  } else if ($argv[1] == 'remove') {
    $bot->removeWebhook();
    exit;
  } else if ($argv[1] == '/newpoll' && !in_array($tomorrow, $holidays)) {
    $messages = array($argv[1], "Wo essen?", "Linde", "Weinberg", "Büro/Grill", "Culmann", "Alter Löwe", "Chinesisch", "Sushi", "Niederdorf", "andere", "/done");
    if(4 == (int)date('N')) {
      // tomorrow it's friday
      //$messages = array($argv[1], "Wo essen? (Friday special)", "Jimmy's", "Weinberg", "Büro/Grill", "Portugies", "Sushi", "Niederdorf", "andere", "/done");
    }
    foreach ($messages as $message) {
      array_push($updates, generateMessage(CHAT_ID, $message, FROM_ID, FROM_FIRST_NAME, CHAT_TITLE));
    }
  } else if ($argv[1] == '/endpoll' && !in_array($today, $holidays)) {
    array_push($updates, generateMessage(CHAT_ID, $argv[1], FROM_ID, FROM_FIRST_NAME, CHAT_TITLE));
  } else if (substr($argv[1], 0, strlen('/menu')) == '/menu') {
    array_push($updates, generateMessage(CHAT_ID, $argv[1], FROM_ID, FROM_FIRST_NAME, CHAT_TITLE));
  }
} else {
  $response = file_get_contents('php://input');
  $update = json_decode($response, true);
  if (substr($update['message']['text'], 0, strlen("/newpoll")) != "/newpoll" && 
      substr($update['message']['text'], 0, strlen("/endpoll")) != "/endpoll") {
    array_push($updates, $update);
  }
}

$bot->init();
foreach ($updates as $update) {
  $bot->onUpdateReceived($update);
  sleep(2);
}
