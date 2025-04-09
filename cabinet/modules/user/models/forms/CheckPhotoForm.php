<?php


namespace cabinet\modules\user\models\forms;

use yii\base\Model;
use cabinet\helpers\FileHelper;

class CheckPhotoForm extends Model
{
    public $file;

    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {

            return FileHelper::savePhoto($this->file->tempName, 'jpg');

        } else {

            return false;

        }
    }
}