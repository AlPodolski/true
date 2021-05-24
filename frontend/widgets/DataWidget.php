<?php


namespace frontend\widgets;

use yii\base\Widget;

class DataWidget extends Widget
{

    public $data;
    public $dataGet;

    public function run()
    {

        switch ($this->data) {
            case 'metro':
                return $this->render('data-metro');
             case 'filter':
                return $this->render('data-filter', ['dataGet' => $this->dataGet]);
        }

        return false;

    }
}