<?php

namespace frontend\modules\user\models\forms;

use frontend\helpers\FileHelper;
use yii\base\Model;

class VideoForm extends Model
{
    public $video;

    public function rules()
    {
        return [
            [['video'], 'file', 'skipOnEmpty' => true],
        ];
    }

    public function upload()
    {

        $type = \explode('/', $this->video->type);

        if ($this->validate()) {

            return FileHelper::saveVideo($this->video->tempName, $type[1]);

        } else {

            return false;

        }
    }

}