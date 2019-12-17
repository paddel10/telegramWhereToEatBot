<?php
require_once "TakeScreenshot.php";
require_once "config.php";

const N68_PDF = 'n68.pdf';
const N68_JPG = 'n68.jpg';
const N68_SLICE_JPG = 'n68Slice.jpg';

if (php_sapi_name() === 'cli') {
    $menu = new GetMenuN68();
    $menu->getMenu();
}

class GetMenuN68
{
    /**
     * @throws ImagickException
     */
    public function getMenu(): void
    {
        $size = [510, 490];
        $today = (new DateTime())->format('Y-m-d');
        $link = 'https://api2.lunchgate.ch/menu/template/?g=955&date=' . $today;
        // download pdf
        $fp = fopen(MENU_PATH . N68_PDF, 'w');
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
        $image->setResolution(300, 300);
        $image->readImage(MENU_PATH . N68_PDF);
        $image->setImageFormat( 'jpg' );
        $image->writeImage(MENU_PATH . N68_JPG);

        // crop
        $imagick = new \Imagick(MENU_PATH . N68_JPG);
        // int $width , int $height , int $x , int $y
        $imagick->cropImage(1400, 1700, $size[0], $size[1]);
        file_put_contents(MENU_PATH . N68_SLICE_JPG, $imagick->getImageBlob());
    }
}