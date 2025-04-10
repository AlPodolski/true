<?php


namespace frontend\modules\user\models\forms;

use frontend\helpers\FileHelper;
use yii\base\Model;

class PhotoForm extends Model
{
    public $photo;

    public function rules()
    {
        return [
            [['photo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 15],
        ];
    }

    public function upload()
    {

        if ($this->validate()) {

            $result = array();

            foreach ($this->photo as $file) {

                $result[] = FileHelper::savePhoto($file->tempName, 'jpg');

            }

            return $result;

        }

        return false;

    }
}