<?php

namespace cabinet\modules\user\models\forms;

use cabinet\helpers\FileHelper;
use yii\base\Model;

class SelphiForm extends Model
{
    public $photo;

    public function rules()
    {
        return [
            [['photo'], 'file', 'skipOnEmpty' => false, 'extensions' => 'jpg, jpeg', 'maxFiles' => 15],
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