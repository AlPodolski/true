<?php


namespace frontend\components\helpers;


use frontend\models\Files;
use Yii;
use yii\web\UploadedFile;


class SaveFileHelper
{
    public static function save(UploadedFile $file, $id, $relatedClass, $relatedId, $main = 0)
    {
        $model = new Files();

        $model->related_class = $relatedClass;

        $model->related_id = $relatedId;

        if (\getimagesize($file->tempName)){

            $type = \explode('/', $file->type);

            $model->file = 'photo-'.$id.'-'.\md5($file->name).\time().'.'.$type[1];

            $dir_hash = DirHelprer::generateDirNameHash($model->file).'/';

            $dir = Yii::$app->params['photo_path'].$dir_hash;

            $save_dir = DirHelprer::prepareDir(Yii::getAlias('@frontend').'/web/'.$dir);

            $file->saveAs($save_dir.$model->file);

            $model->file = $dir.$model->file;

            $model->save();

            return $model;

        }

    }
}