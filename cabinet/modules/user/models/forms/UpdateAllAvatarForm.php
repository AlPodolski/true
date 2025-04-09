<?php

namespace cabinet\modules\user\models\forms;

use cabinet\helpers\FileHelper;
use yii\base\Model;

class UpdateAllAvatarForm extends Model
{
    public $photo;

    public $post_id;

    public function rules()
    {
        return [
            [['photo'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg'],
            [['posts_id'], 'safe'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {

            return FileHelper::savePhoto($this->photo->tempName, 'jpg');

        } else {

            return false;

        }
    }

}