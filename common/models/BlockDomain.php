<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "block_domain".
 *
 * @property int $id
 * @property string|null $domain
 * @property int|null $created_at
 */
class BlockDomain extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'block_domain';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at'], 'integer'],
            [['domain'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'domain' => 'Domain',
            'created_at' => 'Created At',
        ];
    }
}
