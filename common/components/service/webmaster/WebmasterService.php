<?php

namespace common\components\service\webmaster;

use common\models\City;
use Yii;

class WebmasterService
{
    public function add(City $city)
    {
        $webmaster = new Webmaster();

        $hostId = $webmaster->addSite('https://'.$city->actual_city.'.'.$city->domain);

        $code = $webmaster->verifySite($hostId);

        $webmasterCode = new \frontend\models\Webmaster();

        $webmasterCode->tag = $code;
        $webmasterCode->city_name = $city->actual_city;

        $webmasterCode->save();

        Yii::$app->cache->flush();
    }
}