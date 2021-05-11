<?php


namespace frontend\widgets;

use yii\base\Widget;

class DataWidget extends Widget
{

    public $data;

    public function run()
    {

        switch ($this->data) {
            case 'metro':
                return $this->render('data-metro');
        }

        return false;

    }
}