<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cloud_info}}`.
 */
class m231116_105241_create_cloud_info_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%cloud_info}}', [
            'id' => $this->primaryKey(),
            'zone' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%cloud_info}}');
    }
}
