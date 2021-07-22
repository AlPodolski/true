<?php

namespace frontend\modules\advert\models;

use common\models\AdvertCategory;
use common\models\Comments;
use common\models\User;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "advert".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $timestamp
 * @property string|null $text
 * @property string|null $title
 * @property integer $type
 * @property integer $status
 * @property integer $category_id
 */
class Advert extends \yii\db\ActiveRecord
{

    const PUBLIC_TYPE = 0;

    const PRIVATE_CABINET_TYPE = 1;

    const STATUS_CHECK = 1;

    const STATUS_NOT_CHECK = 0;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'advert';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'timestamp', 'type', 'status', 'category_id'], 'integer'],
            [['text', 'title'], 'string'],
            [['text', 'title'], 'required'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserRelations()
    {
        return $this->hasOne(\common\models\User::class, ['id' =>  'user_id'])->with('avatar');
    }

    public function getUserName(){

        return ArrayHelper::getValue(User::find()->where(['id' => $this->user_id])->asArray()->one(), 'username');

    }

    public function getComments(){

        return $this->hasMany(Comments::class, ['related_id' => 'id'])->andWhere(['class' => Advert::class])->with('author');

    }

    public function getCategory() : ActiveQuery
    {
        return $this->hasOne(AdvertCategory::class, ['id' => 'category_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'timestamp' => 'Дата создания',
            'text' => 'Текст',
            'title' => 'Заголовок',
            'status' => 'Статус',
            'category_id' => 'Категория',
        ];
    }
}
