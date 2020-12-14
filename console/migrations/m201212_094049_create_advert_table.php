<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%advert}}`.
 */
class m201212_094049_create_advert_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%advert}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'timestamp' => $this->integer(),
            'text' => $this->text(),
            'title' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%advert}}');
    }
}
