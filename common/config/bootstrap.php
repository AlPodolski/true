<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@web', '');
Yii::setAlias('@user-view', dirname(dirname(__DIR__)) . '/frontend/modules/user/views');
Yii::setAlias('@cabinet', dirname(__DIR__, 2) . '/cabinet');

function dd($string = ''){

    echo '<pre>';

    var_dump($string);

    echo '</pre>';

    die();

}

function mb_ucfirst($text) {

    return mb_strtoupper(mb_substr($text, 0, 1)) . mb_substr($text, 1);

}

function d($string){

    echo '<pre>';

    var_dump($string);

    echo '</pre>';

}