<?php

namespace cabinet\components\service;

use common\models\Phone;
use yii\base\Component;

class AddPhoneService extends Component
{
    public static function handle($addPostEvent)
    {
        $phone = new Phone();

        $phone->phone = $addPostEvent->sender['phone'];

        if ($phone->validate()) $phone->save();
    }
}