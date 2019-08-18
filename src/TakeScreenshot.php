<?php

class TakeScreenshot
{
    /** @var string */
    private $apiKey = '';

    /** @var array */
    private $result = [];

    /**
     * @param string $apiKey
     */
    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @param string $url http(s)://someurl.com
     */
    public function getScreenshot(string $url): void
    {
        $payload = array(
            'key' => $this->apiKey,
            'url' => $url
         );

        $payload = json_encode($payload);

        $ch = curl_init('http://screeenly.com/api/v1/fullsize');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload))
        );
        $result = curl_exec($ch);
        //var_dump($result);
        $this->result = json_decode($result);
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return array_key_exists('path', $this->result) ? $this->result->path : '';
    }

    /**
     * @return string
     */
    public function getBase64(): string
    {
        $result = array_key_exists('base64', $this->result) ? $this->result->base64 : '';
        return str_replace('data:image/jpg;base64,', '', $result);
    }

}