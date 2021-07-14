<?php


namespace frontend\modules\user\models\forms;

use Yii;
use yii\base\Model;

class AddPhoneReviewForm extends Model
{

    public $phone;
    public $city;
    public $text;
    public $category;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone', 'category'], 'required'],
            [['phone'], 'trim'],
            [['phone'], 'phoneFilter'],
            ['text', 'string', 'max' => 750],
            ['city', 'string', 'max' => 40],
            ['city', 'trim'],
            [['category'], 'integer']
        ];
    }

    public function phoneFilter($attribute, $params)
    {
        $this->phone = preg_replace('/[^0-9]/', '', $this->phone);

        if (!$this->hasErrors()) {
            if (mb_strlen($this->phone) != 11) {
                $this->addError($attribute, 'Указан неверный номер, должно быть 11 сиволов');
            }
        }
    }

    public function send()
    {

        $result = \json_decode(Yii::$app->phone->send(
            [
                'phone' => $this->phone,
                'action' => 'add-phone',
                'city' => $this->city,
            ]
        ));

        $data = \json_decode(Yii::$app->phone->send(
            [
                'phone' => $this->phone,
                'text' => $this->text,
                'category' => $this->category,
                'action' => 'send-review',
                'city' => $this->city,
            ]
        ));
    }

    public function attributeLabels()
    {
        return [
            'phone' => 'Номер телефона',
            'text' => 'Описание',
            'city' => 'Город',
        ];
    }

}