<?php

namespace common\models;

use frontend\models\Metro;
use Yii;

/**
 * This is the model class for table "redirect".
 *
 * @property int $id
 * @property string|null $from
 * @property string|null $to
 * @property string|null $user_agent
 * @property string|null $status
 */
class Redirect extends \yii\db\ActiveRecord
{
    const BOT_REDIRECT = 0;
    const HUMAN_REDIRECT = 1;
    const ALL_REDIRECT = 2;

    const STATUS_301 = 0;
    const STATUS_302 = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'redirect';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['from', 'to', 'user_agent', 'status'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from' => 'From',
            'to' => 'To',
            'user_agent' => 'User Agent',
            'status' => 'Status',
        ];
    }

    public static function getRedirect($city)
    {
        $data = Yii::$app->cache->get('redirect_'.$city);

        if ($data === false) {
            // $data нет в кэше, вычисляем заново
            $data = Redirect::findOne(['from' => $city]);
            // Сохраняем значение $data в кэше. Данные можно получить в следующий раз.
            Yii::$app->cache->set('redirect_'.$city, $data);
        }

        return $data;
    }
    
}