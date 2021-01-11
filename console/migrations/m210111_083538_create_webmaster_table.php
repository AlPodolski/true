<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%webmaster}}`.
 */
class m210111_083538_create_webmaster_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%webmaster}}', [
            'id' => $this->primaryKey(),
            'city_id' => $this->smallInteger()->unsigned(),
            'tag' => $this->string(122),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%webmaster}}');
    }
}
