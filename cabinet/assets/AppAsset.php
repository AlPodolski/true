<?php

namespace cabinet\assets;

use yii\web\AssetBundle;

/**
 * Main cabinet application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/nouislider.min.css',
        'css/new-style.css?v=22',
        'css/style.css?v=1',
    ];
    public $js = [
        'js/wNumb.min.js',
        'js/nouislider.min.js',
        'js/new.js?v=10',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        //'yii\bootstrap4\BootstrapAsset',
        //'yii\bootstrap4\BootstrapPluginAsset',
    ];
}
