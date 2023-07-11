<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "spisaniya".
 *
 * @property int $id
 * @property string|null $date
 * @property int|null $count
 */
class Spisaniya extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'spisaniya';
    }

    public static function add($sum)
    {
        $date = date('d-m-Y', time());

        if ($count = self::find()->where(['date' => $date])->one()){

            $count->count = $count->count + $sum;

            $count->save();

        }else{

            $count = new self();

            $count->count = $sum;
            $count->date = $date;

            $count->save();

        }
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
}
