<?php


namespace cabinet\widgets;

use yii\base\Widget;

class PhotoWidget extends Widget
{
    public $path;

    public $size;

    public $width = true;

    public $showPictureHref = false;

    public $options = [];

    public $pictureOptions = [];

    public function run()
    {
        return $this->render('photo', [
            'path' => $this->path,
            'options' => $this->options,
            'size' => $this->size,
            'width' => $this->width,
            'pictureOptions' => $this->pictureOptions,
            'showPictureHref' => $this->showPictureHref,
        ]);
    }
}