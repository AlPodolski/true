<?php


namespace frontend\components\helpers;


use frontend\modules\user\models\Posts;

class GetAdvertisingPost
{
    public static function get($city)
    {

        if ($post = Posts::find()
            ->with('avatar')
            ->where(['city_id' => $city['id']])
            ->andWhere(['status' => Posts::POST_ON_PUPLICATION_STATUS])
            ->andWhere(['>', 'view', 0])
            ->limit(1)
            ->orderBy('RAND()')
            ->one()){

            $post->view = $post->view - 1;

            $post->save();

            $checkBlock['block']['post'] = $post;

            $checkBlock['block']['url'] = '/post/'.$post['id'];

            return $checkBlock;

        }else{
            $checkBlock['block']['post'] = Posts::find()->asArray()
                ->where(['id' => 34])
                ->with('avatar')
                ->cache(3600)->one();

            $checkBlock['block']['header'] = 'Проверенные проститутки с высоким рейтингом';
            $checkBlock['block']['text'] = 'Рейтинг составляется на основе алгоритма
                и ручной модерации мы выбираем только
                качественные анкеты со всего интернета
                что бы показать их вам.';
            $checkBlock['block']['url'] = 'proverennye';

            return $checkBlock;
        }

    }
}