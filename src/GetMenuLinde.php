<?php
require_once "TakeScreenshot.php";
require_once "ExtractLink.php";
require_once "config.php";

const LINDE_JPG = 'linde.jpg';
const LINDE_PNG = 'linde.png';

if (php_sapi_name() === 'cli') {
    $apiKey = $argv[1];

    // monday: https://www.linde-oberstrass.ch/guenstige-mittagsmenues-business-lunch/#menu-1
    $link = 'https://www.linde-oberstrass.ch/guenstige-mittagsmenues-business-lunch/#menu-' . date('N');

    $base64 = '';

    if (!empty($link)) {
        $takeScreenshot = new TakeScreenshot($apiKey);
        $takeScreenshot->getScreenshot($link);
        $base64 = $takeScreenshot->getBase64();
    }
    if (!empty($base64)) {
        $content = file_get_contents($takeScreenshot->getPath());
        file_put_contents(MENU_PATH . LINDE_JPG, $content);

        // crop
        $imagick = new \Imagick(MENU_PATH . LINDE_JPG);
        $imagick->cropImage(709, 424, 270, 1410);
        file_put_contents(MENU_PATH . LINDE_PNG, $imagick->getImageBlob());
    }
}