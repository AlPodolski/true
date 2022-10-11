<?php

namespace frontend\components\helpers;
use Yii;

class CaptchaHelper
{
    public static function check()
    {
        if ( !$_POST['g-recaptcha-response'] ) {

            return false;
        }

        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $key = Yii::$app->params['recaptcha-key'];
        $query = $url.'?secret='.$key.'&response='.$_POST['g-recaptcha-response'].'&remoteip='.$_SERVER['REMOTE_ADDR'];

        $data = json_decode(file_get_contents($query));

        return $data->success;

    }
}