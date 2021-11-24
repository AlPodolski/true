<?php

namespace frontend\components\service\image;

use iutbay\yii2imagecache\ImageCache as ImageC;
use Yii;
use yii\imagine\Image;
use yii\helpers\ArrayHelper;
use Imagine\Image\ManipulatorInterface;
use Imagine\Image\Point;

class ImageCache  extends ImageC
{
    /**
     * Create thumb
     * @param string $srcPath
     * @param string $dstPath
     * @param string $size
     * @param string $mode
     * @return boolean
     */
    public function createThumb($srcPath, $dstPath, $size, $mode = ManipulatorInterface::THUMBNAIL_OUTBOUND)
    {
        if ($size == self::SIZE_FULL) {
            $thumb = \yii\imagine\Image::getImagine()->open($srcPath);
        } else {
            $width = $this->sizes[$size][0];
            $height = $this->sizes[$size][1];
            $thumb = Image::thumbnail($srcPath, $width, $height, $mode);
        }

        if (isset($this->text)) {
            $fontOptions = ArrayHelper::getValue($this->text, 'fontOptions', []);
            $fontSize = ArrayHelper::getValue($fontOptions, 'size', 25);
            $fontColor = ArrayHelper::getValue($fontOptions, 'color', 'fff');
            $fontAngle = ArrayHelper::getValue($fontOptions, 'angle', 40);
            $start = ArrayHelper::getValue($this->text, 'start', [20, 150]);

            $palette = new \Imagine\Image\Palette\RGB();

            $color = $palette->color($fontColor, 50);

            $font = Image::getImagine()->font(Yii::getAlias($this->text['fontFile']), $fontSize, $color);

            $thumb->draw()->text($this->text['text'], $font, new Point($start[0], $start[1]), $fontAngle);

        }

        if ($thumb && $thumb->save($dstPath))
            return true;

        return false;
    }
}