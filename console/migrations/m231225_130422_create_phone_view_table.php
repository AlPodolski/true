<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%phone_view}}`.
 */
class m231225_130422_create_phone_view_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%phone_view}}', [
            'id' => $this->primaryKey(),
            'date' => $this->string(),
            'count' => $this->smallInteger(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%phone_view}}');
    }
}
