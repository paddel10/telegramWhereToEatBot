<?php

class ExtractLink
{
    /** @var string */
    private $baseUrl = 'https://de-de.facebook.com';

    /** @var string */
    private $url = 'https://de-de.facebook.com/pages/category/Tapas-Bar---Restaurant/Caf%C3%A9-Weinberg-1096263017161601/';

    /** @var string */
    private $pattern = '/href="(\/permalink.php\?.*?)"/';

    public function extract(): string
    {
        // url: https://de-de.facebook.com/pages/category/Tapas-Bar---Restaurant/Caf%C3%A9-Weinberg-1096263017161601/
        // pattern: href="/permalink.php?
        //$content = file_get_contents($this->url);
        $userAgent = 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5';
        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent );

        $content = curl_exec($ch);

        $matches = [];
        if (preg_match($this->pattern, $content, $matches)) {
            return $this->baseUrl . htmlspecialchars_decode($matches[1]);
        }
        return '';
    }


}