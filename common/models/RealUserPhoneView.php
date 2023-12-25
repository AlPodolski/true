<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "real_user_phone_view".
 *
 * @property int $id
 * @property string|null $date
 * @property int|null $count
 */
class RealUserPhoneView extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'real_user_phone_view';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['count'], 'integer'],
            [['date'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'count' => 'Count',
        ];
    }

    public static function addView()
    {
        $date = date('d-m-Y', time());

        if ($count = self::find()->where(['date' => $date])->one()){

            $count->count = $count->count + 1;

            $count->save();

        }else{

            $count = new self();

            $count->count = 1;
            $count->date = $date;

            $count->save();

        }
    }

}
