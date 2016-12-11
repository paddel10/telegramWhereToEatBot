<?php

/**
*
* @param $command /newpoll
**/
function generateMessage($chat_id, $command, $from_id, $from_first_name, $chat_title) {
  $isBotCommand = false;
  if ($command[0] == '/') {
    $isBotCommand = true;
  }
  $message = array (
    'update_id' => 0,
    'message' => array (
      'message_id' => time(),
      'from' => array (
        'id' => $from_id,
        'first_name' => $from_first_name,
      ),
      'chat' => array (
        'id' => $chat_id,
        'title' => $chat_title,
        'type' => 'group',
        'all_members_are_administrators' => true,
      ),
      'date' => time(),
      'text' => $command
    )
  );
  if ($isBotCommand) {
    $message['message']['entities'] = array (array (
          'type' => 'bot_command',
          'offset' => 0,
          'length' => strlen($command),
        )
      );
  }
  return $message;
}
