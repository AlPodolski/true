<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class GalleryAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/lightgallery.min.css',
    ];
    public $js = [
        'js/lightgallery-all.min.js'
    ];
    public $depends = [
        'frontend\assets\AppAsset',
    ];
}
