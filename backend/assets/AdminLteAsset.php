<?php

namespace backend\assets;

use yii\web\AssetBundle;


class AdminLteAsset extends AssetBundle
{
    public $sourcePath = '@bower/admin-lte';
    public $css = [
        'dist/css/adminlte.min.css',
    ];
    public $js = [
        'dist/js/adminlte.min.js',
    ];
}