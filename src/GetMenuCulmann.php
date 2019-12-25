<?php
require_once "TakeScreenshot.php";
require_once "ExtractLinkCulmann.php";
require_once "config.php";

const CULMANN_PDF = 'culmann.pdf';
const CULMANN_JPG = 'culmann.jpg';
const CULMANN_SLICE_JPG = 'culmannSlice.jpg';

if (php_sapi_name() === 'cli') {
    $menu = new GetMenuCulmann();
    $menu->getMenu();
}

class GetMenuCulmann
{
    private $weekdayMap = [
        1 => [329, 300],
        2 => [912, 300],
        3 => [1480, 300],
        4 => [2040, 300],
        5 => [2580, 300]
    ];

    /**
     * @throws ImagickException
     */
    public function getMenu(): void
    {
        $extractLink = new ExtractLinkCulmann();
        $link = $extractLink->extract();
        if (!empty($link)) {
            // download pdf
            $fp = fopen(MENU_PATH . CULMANN_PDF, 'w');
            // create curl resource
            $ch = curl_init();

            // set url
            curl_setopt($ch, CURLOPT_URL, str_replace(" ","%20",$link));
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

            curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
            curl_setopt($ch, CURLOPT_FILE, $fp);
            $content = curl_exec($ch);

            // close curl resource to free up system resources
            curl_close($ch);

            // convert to image
            $image = new Imagick();
            $image->setResolution( 300, 300 );
            $image->readImage(MENU_PATH . CULMANN_PDF);
            $image->setImageFormat( 'jpg' );
            $image->writeImage(MENU_PATH . CULMANN_JPG);

            // crop
            $size = $this->weekdayMap[date('N')];
            $imagick = new \Imagick(MENU_PATH . CULMANN_JPG);
            $imagick->cropImage(630, 2000, $size[0], $size[1]);
            file_put_contents(MENU_PATH . CULMANN_SLICE_JPG, $imagick->getImageBlob());
        }
    }
}