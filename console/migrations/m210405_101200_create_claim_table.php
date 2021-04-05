<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%claim}}`.
 */
class m210405_101200_create_claim_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%claim}}', [
            'id' => $this->primaryKey(),
            'author_email' => $this->string(40),
            'author_name' => $this->string(40),
            'text' => $this->string(800),
            'created_at' => $this->integer()->unsigned(),
            'updated_at' => $this->integer()->unsigned(),
            'status' => $this->tinyInteger()->defaultValue(0)->comment('0 обращение не прочитано 1 прочиано и в обработке 2 закрыто'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%claim}}');
    }
}
