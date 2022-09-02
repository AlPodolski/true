<?php


namespace frontend\helpers;


use common\models\National;
use frontend\models\Metro;
use phpDocumentor\Reflection\PseudoTypes\True_;
use Yii;

class RequestHelper
{
    /**
     * @return false|string
     */
    public static function getBackUrl($protocol)
    {

        if (\strstr(Yii::$app->request->headers['referer'], Yii::$app->request->headers['host'])) {

            $ref = \str_replace($protocol . '://', '', Yii::$app->request->headers['referer']);

            $ref = \str_replace('https://', '', $ref);

            return \str_replace(Yii::$app->request->headers['host'], '', $ref) ?? '/';

        }

        return false;

    }

    public static function getRefererCategory($protocol)
    {

        $url = str_replace('https://' . Yii::$app->request->headers['host'] . '/', '', Yii::$app->request->headers['referer']);

        $urlData = explode('-', $url);

        $cacheTime = 3600 * 24 * 30;

        $result = '';

        switch ($urlData[0]) {

            case 'metro':

                $findUrl = str_replace('metro-', '', $url);

                $data = Metro::find()
                    ->select('id')
                    ->where(['url' => $findUrl])
                    ->cache($cacheTime)->one();

                $result = 'metro:' . $data->id;
                break;

            case 'nacionalnost':

                $findUrl = str_replace('nacionalnost-', '', $url);

                $data = National::find()
                    ->select('id')
                    ->where(['url' => $findUrl])
                    ->cache($cacheTime)->one();

                $result = 'nacionalnost:' . $data->id;

                break;

            case 'vozrast':

                $findUrl = str_replace('vozrast-', '', $url);

                $result = 'vozrast:'.$findUrl;

                break;

        }

        return $result;

    }

}