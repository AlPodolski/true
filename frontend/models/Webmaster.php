<?php

namespace frontend\models;

use common\models\City;
use Yii;

/**
 * This is the model class for table "webmaster".
 *
 * @property int $id
 * @property int|null $city_id
 * @property string|null $tag
 */
class Webmaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'webmaster';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['city_id'], 'integer'],
            [['tag'], 'string', 'max' => 122],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city_id' => 'City ID',
            'tag' => 'Tag',
        ];
    }

    public static function getTag($id)
    {
        $data = Yii::$app->cache->get('webmaster_info_'.$id);

        if ($data === false) {
            // $data нет в кэше, вычисляем заново
            $data = Webmaster::find()->where(['city_name' => $id])->orWhere(['city_id' => $id])->asArray()->one();

            // Сохраняем значение $data в кэше. Данные можно получить в следующий раз.
            Yii::$app->cache->set('webmaster_info_'.$id, $data);
        }

        return $data;
    }

}
