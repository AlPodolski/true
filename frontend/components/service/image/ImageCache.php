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

            $thumb->draw()->text($this->text['text'], $font, new Point(450, 300), $fontAngle);

        }

        if ($thumb && $thumb->save($dstPath))
            return true;

        return false;
    }

    /**
     * Create thumb
     * @param string $path thumb path
     * @param boolean $overwrite
     * @return boolean
     */
    public function create($path, $overwrite = true)
    {
        // test path
        $info = $this->getPathInfo($path);
        if (!is_array($info))
            return false;

        // check original image
        if (!file_exists($info['srcPath']))
            return false;

        // check destination folder
        $folder = preg_replace('#/[^/]*$#', '', $info['dstPath']);
        if (!file_exists($folder))
            @mkdir($folder, 0777, true);

        // create thumb
        return $this->createThumb($info['srcPath'], $info['dstPath'], $info['size'], $this->resizeMode);
    }

    /**
     * Get size suffixes regexp
     * @return string regexp
     */
    private function getSizeSuffixesRegexp()
    {
        return join('|', $this->getSizeSuffixes());
    }

    private function getSizeSuffixes()
    {
        $suffixes = [];
        foreach ($this->sizes as $size => $sizeConf) {
            $suffixes[$size] = ArrayHelper::getValue($this->sizeSuffixes, $size, $this->defaultSizeSuffix . $size);
        }
        return $suffixes;
    }

    /**
     * Get info from path
     * @param string $path
     * @return null|array
     */
    private function getPathInfo($path)
    {

        $result = false;
        $regexp = '#^(.*)(' . $this->getSizeSuffixesRegexp() . ')\.(' . $this->getExtensionsRegexp() . ')$#';
        if (preg_match($regexp, $path, $matches)) {
            $result = [
                'size' => $this->getSizeFromSuffix($matches[2]),
                'srcPath' => $this->sourcePath . '/' . $matches[1] . '.' . str_replace('webp', 'jpg',$matches[3]),
                'dstPath' => $this->thumbsPath . '/' . $path,
                'extension' => $matches[3],
            ];
        } else if (preg_match('#^(.*)\.(' . $this->getExtensionsRegexp() . ')$#', $path, $matches)) {
            return [
                'size' => self::SIZE_FULL,
                'srcPath' => $this->sourcePath . '/' . $matches[1] . '.' . str_replace('webp', 'jpg',$matches[2]),
                'dstPath' => $this->thumbsPath . '/' . $path,
                'extension' => $matches[2],
            ];
        }

        if (isset($result['srcPath']) and !file_exists($result['srcPath']))
            $result['srcPath'] = str_replace('.jpg', '.jpeg', $result['srcPath']);

        return $result;

    }

    /**
     * Get size from suffix
     * @param string $suffix
     * @return string size
     */
    private function getSizeFromSuffix($suffix)
    {
        return array_search($suffix, $this->getSizeSuffixes());
    }

}