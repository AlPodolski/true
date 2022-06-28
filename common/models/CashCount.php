<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cash_count".
 *
 * @property int $id
 * @property string|null $date
 * @property int|null $count
 */
class CashCount extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cash_count';
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
