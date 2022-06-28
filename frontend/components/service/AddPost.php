<?php

namespace frontend\components\service;

use yii\base\Component;

use common\models\PostCount;

class AddPost extends Component
{
    public static function handle($addPostEvent)
    {
        $date = date('d-m-Y', time());

        if ($count = PostCount::find()->where(['date' => $date])->one()){

            $count->count = $count->count + 1;

            $count->save();

        }else{

            $count = new PostCount();

            $count->count = 1;
            $count->date = $date;

            $count->save();

        }
    }
}