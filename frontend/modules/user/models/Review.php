<?php

namespace frontend\modules\user\models;

use Yii;

/**
 * This is the model class for table "review".
 *
 * @property int $id
 * @property int|null $post_id
 * @property string|null $text
 * @property int|null $photo_marc
 * @property int|null $service_marc
 * @property int|null $total_marc
 * @property int|null $s_klass_marc
 * @property int|null $mbr_marc
 * @property int|null $finish_v_rot_marc
 */
class Review extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'review';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['post_id', 'photo_marc', 'service_marc', 'total_marc', 's_klass_marc', 'mbr_marc', 'finish_v_rot_marc'], 'integer'],
            [['text'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'post_id' => 'Post ID',
            'text' => 'Text',
            'photo_marc' => 'Photo Marc',
            'service_marc' => 'Service Marc',
            'total_marc' => 'Total Marc',
            's_klass_marc' => 'S Klass Marc',
            'mbr_marc' => 'Mbr Marc',
            'finish_v_rot_marc' => 'Finish V Rot Marc',
        ];
    }
}
