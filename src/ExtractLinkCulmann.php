<?php


class ExtractLinkCulmann
{
    /** @var string */
    private $baseUrl = 'https://www.culmann.ch';

    /** @var string */
    private $url = 'https://www.culmann.ch/essen-trinken/';

    /** @var string */
    private $pattern = '/<a href="(\/app\/download\/.*?)"/';

    public function extract(): string
    {
        $userAgent = 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5';
        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $userAgent );

        $content = curl_exec($ch);
        curl_close($ch);

        $matches = [];
        if (preg_match($this->pattern, $content, $matches)) {
            return $this->baseUrl . htmlspecialchars_decode($matches[1]);
        }
        return '';
    }
}