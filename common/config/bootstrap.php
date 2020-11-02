<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');

function dd($string = ''){

    echo '<pre>';

    var_dump($string);

    echo '</pre>';

    die();

}

function d($string){

    echo '<pre>';

    var_dump($string);

    echo '</pre>';

}