<?php


namespace frontend\widgets;

use yii\base\Widget;

class PhotoWidget extends Widget
{
    public $path;

    public $size;

    public $options = [];

    public function run()
    {
        return $this->render('photo', [
            'path' => $this->path,
            'options' => $this->options,
            'size' => $this->size,
        ]);
    }
}