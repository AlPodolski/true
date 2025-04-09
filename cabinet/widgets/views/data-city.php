<?php

/* @var $cityList \common\models\City[]|null */

if ($cityList) foreach ($cityList as $item) {

    $cityUrl = $item['url'];
    $domain = Yii::$app->params['domain'];

    if ($item['actual_city']) $cityUrl = $item['actual_city'];
    if ($item['domain']) $domain = $item['domain'];

    echo \yii\helpers\Html::tag(
        'li',
        \yii\helpers\Html::a(
            $item->city,
            'https://' . $cityUrl . '.' . $domain,
            ['class' => 'red-link']
        )
    );

}else echo 'Ничего не найдено';