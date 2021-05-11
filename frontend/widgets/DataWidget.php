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
             case 'filter':
                return $this->render('data-filter');
        }

        return false;

    }
}