<?php


namespace cabinet\components\helpers;


class DirHelprer
{
    public static function prepareDir($dir){

        if (\is_dir($dir)) return $dir;

        if (mkdir($dir)) return $dir;

    }

    public static function generateDirNameHash($name){

        return \substr(\md5($name), 0, 3);

    }
}