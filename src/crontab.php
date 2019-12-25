<?php
require_once 'holidays.php';

$str = $argv[1];

$tomorrow = date("d.m.Y", strtotime(date("d.m.Y") . ' + 1 day'));
$holidays = getHolidays();

if (php_sapi_name() === 'cli' && !in_array($tomorrow, $holidays)) {
    system(dirname(__FILE__) . DIRECTORY_SEPARATOR .  'poll-bot-webhook.php "' . $str . '"');
}
