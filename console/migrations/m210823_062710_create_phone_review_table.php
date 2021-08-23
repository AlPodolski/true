<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%phone_review}}`.
 */
class m210823_062710_create_phone_review_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%phone_review}}', [
            'id' => $this->primaryKey(),
            'phone_id' => $this->integer(),
            'call_category_id' => $this->integer(),
            'text' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%phone_review}}');
    }
}
