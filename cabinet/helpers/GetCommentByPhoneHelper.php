<?php

namespace cabinet\helpers;

use common\models\Phone;

class GetCommentByPhoneHelper
{

    public $phone;

    public function __construct($phone)
    {
        $this->phone = $phone;
    }

    public function get()
    {
        $this->preparePhone();

        $phone = Phone::find()->where(['like', 'phone', $this->phone])->with('comments')->one();

        return $phone;
    }

    private function preparePhone()
    {
        $this->phone = preg_replace('/[^0-9]/', '', $this->phone);
    }

}