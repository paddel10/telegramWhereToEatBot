<?php
require_once "TakeScreenshot.php";
require_once "ExtractLinkJohanniter.php";
require_once "config.php";

const JOHANNITER_PDF = 'johanniter.pdf';
const JOHANNITER_JPG = 'johanniter.jpg';
const JOHANNITER_SLICE_JPG = 'johanniterSlice.jpg';

$size = [800, 1400];

if (php_sapi_name() === 'cli') {
    $extractLink = new ExtractLinkJohanniter();
    $link = $extractLink->extract();
    if (!empty($link)) {
        // download pdf
        $fp = fopen(MENU_PATH . JOHANNITER_PDF, 'w');
        // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, str_replace(" ", "%20", $link));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        curl_setopt($ch, CURLOPT_FILE, $fp);
        $content = curl_exec($ch);

        // close curl resource to free up system resources
        curl_close($ch);

        // convert to image
        $image = new Imagick();
        $image->setResolution(300, 300);
        $image->readImage(MENU_PATH . JOHANNITER_PDF);
        $image->setImageFormat('jpg');
        $image->writeImage(MENU_PATH . JOHANNITER_JPG);

        // crop
        $imagick = new \Imagick(MENU_PATH . JOHANNITER_JPG);
        $imagick->cropImage(2500, 2100, $size[0], $size[1]);
        echo $imagick->resizeImage(1024, 0, Imagick::FILTER_LANCZOS, 0.9, true);
        file_put_contents(MENU_PATH . JOHANNITER_SLICE_JPG, $imagick->getImageBlob());
    }
}