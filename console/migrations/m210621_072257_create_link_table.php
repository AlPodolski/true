<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%link}}`.
 */
class m210621_072257_create_link_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%link}}', [
            'id' => $this->primaryKey(),
            'url' => $this->string()->comment('url на которой распологается ссылка'),
            'link' => $this->string()->comment('url на которой ведет ссылка'),
            'text' => $this->string()->comment('текст ссылки'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%link}}');
    }
}
