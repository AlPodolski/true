<?php


namespace frontend\assets;

use yii\web\AssetBundle;

class JqueryMaskedInputAsset extends AssetBundle
{
    public $sourcePath = '@bower/jquery-maskedinput';

    public $js = [
        'dist/jquery.maskedinput.min.js',
    ];

    public $depends = [
        'frontend\assets\AppAsset',
    ];
}