<?php
require_once "TakeScreenshot.php";
require_once "config.php";

const ETH_JPG = 'eth.jpg';
const ETH_PNG = 'eth.png';

if (php_sapi_name() === 'cli') {
    $apiKey = $argv[1];

    // date: https://ethz.ch/de/campus/erleben/gastronomie-und-einkaufen/gastronomie/menueplaene/offerDay.html?language=de&id=12&date=2019-08-28
    $link = 'https://ethz.ch/de/campus/erleben/gastronomie-und-einkaufen/gastronomie/menueplaene/offerDay.html?language=de&id=12&date=' . date('Y-m-d');

    $base64 = '';

    if (!empty($link)) {
        $takeScreenshot = new TakeScreenshot($apiKey);
        $takeScreenshot->getScreenshot($link);
        $base64 = $takeScreenshot->getBase64();
    }
    if (!empty($base64)) {
        $content = file_get_contents($takeScreenshot->getPath());
        file_put_contents(MENU_PATH . ETH_JPG, $content);

        // crop
        $imagick = new \Imagick(MENU_PATH . ETH_JPG);
        $imagick->cropImage(673, 880, 335, 530);
        file_put_contents(MENU_PATH . ETH_PNG, $imagick->getImageBlob());
    }
}