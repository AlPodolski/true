<?php

namespace common\components\events;

use common\models\UserCountRegister;
use yii\base\Component;

class UserRegister extends Component
{
    public static function handle()
    {
        $date = date('d-m-Y', time());

        if ($count = UserCountRegister::find()->where(['date' => $date])->one()){

            $count->count = $count->count + 1;

            $count->save();

        }else{

            $count = new UserCountRegister();

            $count->count = 1;
            $count->date = $date;

            $count->save();

        }
    }
}