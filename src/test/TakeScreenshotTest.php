<?php

require_once "../TakeScreenshot.php";
require_once "../ExtractLink.php";

$apiKey = $argv[1];

$extractLink = new ExtractLink();
$link = $extractLink->extract();
$base64 = '';

if (!empty($link)) {
    $takeScreenshot = new TakeScreenshot($apiKey);
    $takeScreenshot->getScreenshot($link);
    $base64 = $takeScreenshot->getBase64();
}
if (!empty($base64)) {
    $content = file_get_contents($takeScreenshot->getPath());
    file_put_contents('tmp.jpg', $content);

    // crop
    $imagick = new \Imagick('tmp.jpg');
    $imagick->cropImage(516, 650, 188, 95);
    file_put_contents('tmp.png', $imagick->getImageBlob());
}