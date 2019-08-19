<?php
require_once "TakeScreenshot.php";
require_once "ExtractLink.php";
require_once "config.php";

const WEINBERG_JPG = 'weinberg.jpg';
const WEINBERG_PNG = 'weinberg.png';

if (php_sapi_name() === 'cli') {
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
        file_put_contents(MENU_PATH . WEINBERG_JPG, $content);

        // crop
        $imagick = new \Imagick(MENU_PATH . WEINBERG_JPG);
        $imagick->cropImage(516, 650, 188, 95);
        file_put_contents(MENU_PATH . WEINBERG_PNG, $imagick->getImageBlob());
    }
}