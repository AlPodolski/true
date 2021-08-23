<?php

namespace frontend\models\forms;

use common\models\Phone;
use common\models\PhoneReview;
use frontend\modules\user\models\Posts;
use yii\base\Model;

class PhoneReviewForm extends Model
{
    public $post_id;

    public $text;

    public $reviewCategoryId;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'reviewCategoryId'], 'integer'],
            [['post_id'], 'required'],
            [['text'], 'string'],
            [['text'], 'validateText'],
        ];
    }

    public function validateText($attribute)
    {
        if (!$this->hasErrors()) {
            $this->text = \htmlspecialchars($this->text);
        }
    }

    public function save()
    {

        $postPhone = Posts::find()->select('phone')->where(['id' => $this->post_id ])->asArray()->one();

        if (!$phone = Phone::find()->where(['phone' => $postPhone['phone']])->one()){

            $phone = new Phone();

            $phone->phone = $postPhone['phone'];

            $phone->save();

        }

        $phoneReview = new PhoneReview();

        $phoneReview->call_category_id = $this->reviewCategoryId;
        $phoneReview->phone_id = $phone->id;
        $phoneReview->text = $this->text;

        return $phoneReview->save();

    }

}