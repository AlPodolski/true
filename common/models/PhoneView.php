<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "phone_view".
 *
 * @property int $id
 * @property string|null $date
 * @property int|null $count
 */
class PhoneView extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'phone_view';
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
