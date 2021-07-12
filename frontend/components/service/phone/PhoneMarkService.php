<?php


namespace frontend\components\service\phone;

use yii\base\Component;

class PhoneMarkService extends Component
{

    /**
     * @var string
     */
    public $token;

    const PHONE_ADMIN_URL = 'https://phone.sex-true.com';

    const ADD_PHONE_URI = '/phones/add-phone/';

    const GET_CATEGORY_URI = '/client-category/get';

    const SEND_REVIEW_URI = '/phones/add-review/';

    const GET_REVIEW_URI = '/phones/view/';

    const TOKEN = '?access-token=';

    /**
     * @param $data
     * @return bool|string
     */
    public function send($data)
    {
        $url = self::PHONE_ADMIN_URL;

        switch ($data['action']) {

            case "add-phone":

                $url .= self::ADD_PHONE_URI.$data['phone'];

                break;

            case "get-review":

                $url .= self::GET_REVIEW_URI.$data['phone'];

                break;

            case "get-category":

                $url .= self::GET_CATEGORY_URI;

                break;

            case "send-review":

                $url .= self::SEND_REVIEW_URI.$data['phone'];

                break;

        }

        $url .= self::TOKEN.$this->token;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));  //Post Fields
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $headers = [
            'Content-Type: application/json',
        ];

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        return curl_exec ($ch);
    }

}