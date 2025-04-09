<?php


namespace cabinet\assets;

use yii\web\AssetBundle;

class SingleAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/owl.theme.default.min.css',
        'css/owl.carousel.min.css',
    ];
    public $js = [
        'js/owl.carousel.js'
    ];

}
