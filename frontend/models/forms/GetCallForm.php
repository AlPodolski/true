<?php


namespace frontend\models\forms;

use common\models\City;
use common\models\RequestCall;
use frontend\modules\user\models\Posts;
use Yii;
use yii\base\Model;

class GetCallForm extends Model
{
    public $phone;
    public $post_id;
    public $text;
    public $user_id;

    public function rules()
    {
        return [
            [['phone', 'post_id'], 'required'],
            [['phone', 'post_id'], 'trim'],
            [['phone'], 'cleanPhone'],
            [['post_id', 'user_id'], 'integer'],
            [['text'], 'string'],
            [['phone'], 'string', 'min' => 10 , 'max' => 12 ],
        ];
    }

    public function cleanPhone($attribute, $params)
    {
        $this->phone = preg_replace('/[^0-9]/', '', $this->phone);
    }

    public function save()
    {
        $requestCall = new RequestCall();

        $requestCall->text = $this->text;
        $requestCall->phone = $this->phone;
        $requestCall->user_id = $this->user_id;
        $requestCall->post_id = $this->post_id;

        $post = Posts::find()->where(['id' => $this->post_id])->limit(1)->one();

        $city = City::find()->where(['id' => $post['city_id']])->one();

        $result = \json_decode(Yii::$app->phone->send(
            [
                'phone' => $this->phone,
                'action' => 'add-phone',
                'city' => $city['city'],
            ]
        ));


        return $requestCall->save();
    }

}