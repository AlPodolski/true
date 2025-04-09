<?php


namespace cabinet\assets;

use yii\web\AssetBundle;

class RateAsset extends AssetBundle
{
    public $sourcePath = '@bower/rateyo';
    public $css = [
        'min/jquery.rateyo.min.css',
    ];
    public $js = [
        'min/jquery.rateyo.min.js',
    ];

    public $depends = [
        'cabinet\assets\AppAsset',
    ];

}