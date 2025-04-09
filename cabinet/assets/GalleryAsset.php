<?php

namespace cabinet\assets;

use yii\web\AssetBundle;

/**
 * Main cabinet application asset bundle.
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
        'cabinet\assets\AppAsset',
    ];
}
