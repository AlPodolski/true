<?php


namespace frontend\helpers;

use Yii;
use yii\imagine\Image;


class FileHelper
{
    public static function savePhoto($file, $extension)
    {
        $saveFileName = \md5($file).\time().'.'.$extension;

        $dir_hash = self::generateDirNameHash($saveFileName).'/';

        $dir = Yii::$app->params['photo_path'].$dir_hash;

        if ($save_dir = self::prepareDir(Yii::getAlias('@webroot').$dir) and self::prepareImage($file, $save_dir, $saveFileName)){

            return $dir.$saveFileName;

        }

        return false;

    }

    public static function regenerateImg($img, $width , $save_path){

        return Image::resize ($img, $width, 9999)->save($save_path, ['quality' => 78]);

    }

    public static function prepareImage( $file, $save_dir, $file_name,  $max_with = 1024){

        $size = \getimagesize($file);

        if ($size[0] > $max_with) $result = self::regenerateImg($file, $max_with, $save_dir.$file_name );
        else $result = self::regenerateImg($file, $size[0], $save_dir.$file_name );

        return $result;

    }

    public static function prepareDir($dir){

        if (\is_dir($dir)) return $dir;

        if (mkdir($dir)) return $dir;

        return false;

    }

    public static function generateDirNameHash($name){

        return \substr(\md5($name), 0, 3);

    }

}