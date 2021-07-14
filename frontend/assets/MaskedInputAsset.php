<?php


namespace frontend\assets;

use yii\web\AssetBundle;

class MaskedInputAsset extends AssetBundle
{
    public $sourcePath = '@bower/jquery-maskedinput';

    public $js = [
        'dist/jquery.maskedinput.min.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}