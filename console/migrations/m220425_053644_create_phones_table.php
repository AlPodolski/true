<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%phones}}`.
 */
class m220425_053644_create_phones_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%phones_advert}}', [
            'id' => $this->primaryKey(),
            'phone' => $this->string(),
            'price' => $this->integer()->defaultValue(0),
            'view' => $this->integer()->unsigned()->defaultValue(0),
            'last_view' => $this->integer()->unsigned()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%phones_advert}}');
    }
}
