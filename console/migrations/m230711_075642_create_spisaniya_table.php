<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%spisaniya}}`.
 */
class m230711_075642_create_spisaniya_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%spisaniya}}', [
            'id' => $this->primaryKey(),
            'date' => $this->string(),
            'count' => $this->integer()->unsigned()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%spisaniya}}');
    }
}
