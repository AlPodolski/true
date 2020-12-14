<?php

namespace frontend\modules\advert\models;

use common\models\Comments;
use frontend\modules\user\User;
use frontend\modules\wall\models\Wall;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "advert".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $timestamp
 * @property string|null $text
 * @property string|null $title
 */
class Advert extends \yii\db\ActiveRecord
{
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
            [['user_id', 'timestamp'], 'integer'],
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

        return ArrayHelper::getValue(Profile::find()->where(['id' => $this->user_id])->asArray()->one(), 'username');

    }

    public function getComments(){

        return $this->hasMany(Comments::class, ['related_id' => 'id'])->andWhere(['class' => Advert::class])->with('author');

    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'timestamp' => 'Timestamp',
            'text' => 'Добавить объявление',
        ];
    }
}
