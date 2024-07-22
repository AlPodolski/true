<?php

namespace common\components\service\webmaster;

use GuzzleHttp\Client;

class Webmaster
{

    private $client;
    private $access_token = 'y0_AgAAAABNB5owAAOcKgAAAADj-ZoaFQ2AImXXTSSKrpFrlxvoUYxeHN8';

    protected $user_id;

    public function __constructor()
    {
        $this->client = new Client();

        $this->getUser();
    }

    public function addSite($host)
    {
        try {

            $host = array('host_url' => $host);

            $response = $this->client->request('POST', 'https://api.webmaster.yandex.net/v4/user/' . $this->user_id . '/hosts', [
                'json' => $host,
                'headers' => [
                    'Authorization' => 'OAuth ' . $this->access_token,
                    'Content-Type' => 'application/json',
                ],
            ]);

            $body = $response->getBody();

            $body = json_decode($body, true);

            return $body['host_id'];

        } catch (Exception $e) {
            // Handle error
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }

    public function verifySite($host)
    {
        try {
            $response = $this->client->request('POST', 'https://api.webmaster.yandex.net/v4/user/' . $this->user_id . '/hosts/' . $host . '/verification?verification_type=META_TAG', [
                'headers' => [
                    'Authorization' => 'OAuth ' . $this->access_token,
                ]
            ]);

            $body = $response->getBody();

            $body = json_decode($body, true);

            return $body['verification_uin'];

        } catch (Exception $e) {
            // Handle error
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }

    private
    function getUser()
    {

        $response = $this->client->request('GET', 'https://api.webmaster.yandex.net/v4/user', [
            'headers' => [
                'Authorization' => 'OAuth ' . $this->access_token
            ]
        ]);

        $body = $response->getBody();

        $body = json_decode($body, true);

        $this->user_id = $body['user_id'];

    }
}