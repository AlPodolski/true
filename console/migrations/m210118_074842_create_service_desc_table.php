<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%service_desc}}`.
 */
class m210118_074842_create_service_desc_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%service_desc}}', [
            'service_id' => $this->smallInteger()->unsigned(),
            'post_id' => $this->integer()->unsigned(),
            'text' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%service_desc}}');
    }
}
