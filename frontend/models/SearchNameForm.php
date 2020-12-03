<?php


namespace frontend\models;

use yii\base\Model;

class SearchNameForm extends Model
{
    public $name;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string' , 'max' => 25],
        ];
    }

}