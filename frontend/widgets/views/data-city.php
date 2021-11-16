<?php

/* @var $cityList \common\models\City[]|null */

if ($cityList) foreach ($cityList as $item) {

    echo \yii\helpers\Html::tag(
        'li',
        \yii\helpers\Html::a(
            $item->city,
            'https://' . $item->url . '.' . Yii::$app->params['site_name'],
            ['class' => 'red-link']
        )
    );

}else echo 'Ничего не найдено';