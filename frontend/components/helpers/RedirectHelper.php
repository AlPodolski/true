<?php

namespace frontend\components\helpers;

use common\models\City;
use common\models\Redirect;
use Yii;

class RedirectHelper
{
    public static function redirect($city)
    {

        $host = str_replace($city .'.', '',  $_SERVER['HTTP_HOST']);

        $cityName =  preg_replace('/[0-9]+/', '', $city);

        $cityInfo = City::find()
            ->where(['url' => $cityName])
            ->cache(1)
            ->one();

        if (isset($cityInfo->domain) and $cityInfo->domain){

            Yii::$app->params['domain'] = $cityInfo->domain;

            if ($host != $cityInfo->domain){

                $url = 'https://'.$city.'.'.Yii::$app->params['domain'].Yii::$app->request->url;

                header('Location: '.$url, true, 301);

                exit();

            }

        }

        if ($cityInfo['actual_city'] == $city and $cityInfo['external_domain']){

            if (
                !\strstr(Yii::$app->request->userAgent, 'yandex') and
                !\strstr(Yii::$app->request->userAgent, 'google')
            ){

                $url = 'https://'.$cityInfo['external_domain'].'.'.Yii::$app->params['domain'].Yii::$app->request->url;

                header('Location: '.$url, true, 301);

                exit();

            }

        }

        if ($cityInfo['external_domain'] == $city and $cityInfo['actual_city']){

            if (
                \strstr(Yii::$app->request->userAgent, 'yandex') or
                \strstr(Yii::$app->request->userAgent, 'google')
            ){

                $url = 'https://'.$cityInfo['actual_domain'].'.'.Yii::$app->params['domain'].Yii::$app->request->url;

                header('Location: '.$url, true, 302);

                exit();

            }

        }

        if ($cityInfo['external_domain'] and $cityInfo['actual_city'] and $city != $cityInfo['external_domain'] and $city != $cityInfo['actual_city']){

            if (
                \strstr(Yii::$app->request->userAgent, 'yandex') or
                \strstr(Yii::$app->request->userAgent, 'google')
            ){

                $url = 'https://'.$cityInfo['actual_domain'].'.'.Yii::$app->params['domain'].Yii::$app->request->url;

                header('Location: '.$url, true, 302);

                exit();

            }else{

                $url = 'https://'.$cityInfo['external_domain'].'.'.Yii::$app->params['domain'].Yii::$app->request->url;

                header('Location: '.$url, true, 301);

                exit();

            }

        }

        if ( $redirects = Redirect::find()->where(['from' => $city])->cache(3600)->all()){

            foreach ($redirects as $redirect){

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

    }

    public static function sendHeader(Redirect $redirect)
    {
        $url = 'https://'.$redirect->to.'.'.Yii::$app->params['domain'].Yii::$app->request->url;

        if ($redirect->status == Redirect::STATUS_301 )header('Location: '.$url, true, 301);
        if ($redirect->status == Redirect::STATUS_302 )header('Location: '.$url, true, 302);

        exit();
    }

}