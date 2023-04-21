<?php

/* @var $cityList \common\models\City[]|null */

if ($cityList) foreach ($cityList as $item) {

    $cityUrl = $item['url'];

    if ($item['actual_city']) $cityUrl = $item['actual_city'];

    echo \yii\helpers\Html::tag(
        'li',
        \yii\helpers\Html::a(
            $item->city,
            'https://' . $cityUrl . '.' . Yii::$app->params['site_name'],
            ['class' => 'red-link']
        )
    );

}else echo 'Ничего не найдено';