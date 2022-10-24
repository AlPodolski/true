<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "claim".
 *
 * @property int $id
 * @property string|null $author_email
 * @property string|null $author_name
 * @property string|null $text
 * @property string|null $ip
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $status 0 обращение не прочитано 1 прочиано и в обработке 2 закрыто
 */
class Claim extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'claim';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'status'], 'integer'],
            [['author_email', 'author_name', 'text'], 'required'],
            [['author_email', 'author_name'], 'string', 'max' => 40],
            [['author_email'], 'email'],
            [['text'], 'string', 'max' => 800],
            [['text'], 'validateText'],
            [['ip'], 'validateIp'],
        ];
    }

    public function validateText($attribute)
    {
        if (!$this->hasErrors()) {
            $this->text = \htmlspecialchars($this->text);
        }
    }

    public function validateIp($attribute)
    {
        if (!$this->hasErrors()) {

            $ip = Claim::find()->where(['ip' => $this->ip])
                ->andWhere(['>', 'created_at', time() - (3600 * 24)])->count();

            if ($ip > 2) {

                $this->addError($attribute, 'Много запросов');

            }

        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_email' => ' Email автора',
            'author_name' => 'Имя авторра',
            'text' => 'Тест',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
            'status' => 'Статус',
        ];
    }
}
