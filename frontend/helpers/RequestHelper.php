<?php


namespace frontend\helpers;


use Yii;

class RequestHelper
{
    /**
     * @return false|string
     */
    public static function getBackUrl($protocol)
    {

        if (\strstr(Yii::$app->request->headers['referer'], Yii::$app->request->headers['host'])){

            $ref = \str_replace($protocol.'://', '',Yii::$app->request->headers['referer']);

            $ref = \str_replace('https://', '', $ref);

            return \str_replace(Yii::$app->request->headers['host'], '', $ref) ?? '/';

        }

        return false;

    }
}