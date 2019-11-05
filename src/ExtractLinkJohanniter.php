<?php

class ExtractLinkJohanniter
{
    /** @var string */
    private $url = 'https://johanniter.com/en/restaurant-2/1339-2/';

    /** @var string */
    // <a href="https://johanniter.com/wp-content/uploads/2019/10/25.10.2019-Käsehörnli-Tagesmenü.pdf" class="pdfemb-viewer" style="" data-width="max" data-height="max"  data-toolbar="top" data-toolbar-fixed="off">25.10.2019-Käsehörnli-Tagesmenü<br/></a>
    private $pattern = '/<a href="(https:\/\/johanniter.com\/wp-content\/uploads\/\d{4}\/\d{2}\/\d{2}\.\d{2}\.\d{4}-.*?.pdf)"/';

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
            return htmlspecialchars_decode($matches[1]);
        }
        return '';
    }
}