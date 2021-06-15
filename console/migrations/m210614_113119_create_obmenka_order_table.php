<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%obmenka_order}}`.
 */
class m210614_113119_create_obmenka_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%obmenka_order}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'sum' => $this->smallInteger(),
            'tracking' => $this->string(40),
            'created_at' => $this->integer()->unsigned(),
            'status' => $this->tinyInteger()->unsigned()->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%obmenka_order}}');
    }
}
