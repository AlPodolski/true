<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ip_phone_count}}`.
 */
class m230412_125233_create_ip_phone_count_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%ip_phone_count}}', [
            'id' => $this->primaryKey(),
            'date' => $this->string(),
            'count' => $this->smallInteger()->unsigned()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%ip_phone_count}}');
    }
}
