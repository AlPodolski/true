<?php


namespace cabinet\components\helpers;


use cabinet\models\Files;
use Yii;
use yii\web\UploadedFile;


class SaveFileHelper
{
    public static function save(UploadedFile $file, $id, $relatedClass, $relatedId, $main = 0)
    {
        $model = new Files();

        $model->related_class = $relatedClass;

        $model->related_id = $relatedId;

        $type = \explode('/', $file->type);

        if ($type[1] != 'jpeg' and $type[1] != 'jpg' and $type[1] != 'pdf' and $type[1] != 'png')  exit();

        $model->file = 'file-' . $id . '-' . \md5($file->name) . \time() . '.' . $type[1];

        $dir_hash = DirHelprer::generateDirNameHash($model->file) . '/';

        $dir = Yii::$app->params['photo_path'] . $dir_hash;

        $save_dir = DirHelprer::prepareDir(Yii::getAlias('@cabinet') . '/web/' . $dir);

        $file->saveAs($save_dir . $model->file);

        $model->file = $dir . $model->file;

        $model->save();

        return $model;

    }
}