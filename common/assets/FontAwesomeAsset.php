<?php


namespace common\assets;
use yii\web\AssetBundle;

class FontAwesomeAsset extends AssetBundle
{
    public $sourcePath = '@bower/fontawesome';
    public $css = [
        'web-fonts-with-css/css/fontawesome-all.min.css',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}