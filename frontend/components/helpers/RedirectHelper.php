<?php

namespace frontend\components\helpers;

use common\models\Redirect;
use Yii;

class RedirectHelper
{
    public static function redirect($city)
    {

        if ($redirect = Redirect::findOne(['from' => $city])){

            if ($redirect->user_agent == Redirect::ALL_REDIRECT){

                self::sendHeader($redirect);

            }

            if ($redirect->user_agent == Redirect::HUMAN_REDIRECT){

                if (
                    !\strstr(Yii::$app->request->userAgent, 'yandex') and
                    !\strstr(Yii::$app->request->userAgent, 'google')
                ){

                    self::sendHeader($redirect);

                }

            }

            if ($redirect->user_agent == Redirect::BOT_REDIRECT){

                if (
                    \strstr(Yii::$app->request->userAgent, 'yandex') or
                    \strstr(Yii::$app->request->userAgent, 'google')
                ){

                    self::sendHeader($redirect);

                }

            }

        }

    }

    public static function sendHeader(Redirect $redirect)
    {
        $url = 'https://'.$redirect->to.'.'.Yii::$app->params['domain'].Yii::$app->request->url;

        header('Location: '.$url);

        exit();
    }

}