<?php


namespace frontend\modules\user\models\forms;

use frontend\helpers\FileHelper;
use yii\base\Model;

class AvatarForm extends Model
{
    public $avatar;

    public function rules()
    {
        return [
            [['avatar'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {

            return FileHelper::savePhoto($this->avatar->tempName, 'jpg');

        } else {

            return false;

        }
    }

}