<?php


namespace cabinet\modules\user\models\forms;

use cabinet\helpers\FileHelper;
use yii\base\Model;

class AvatarForm extends Model
{
    public $avatar;

    public $post_id;

    public function rules()
    {
        return [
            [['avatar'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg'],
            [['post_id'], 'integer'],
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