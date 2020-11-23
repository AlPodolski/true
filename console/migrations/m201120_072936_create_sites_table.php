<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%sites}}`.
 */
class m201120_072936_create_sites_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%sites}}', [
            'id' => $this->primaryKey(),
            'url' => $this->string(50),
            'name' => $this->string(50),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%sites}}');
    }
}
