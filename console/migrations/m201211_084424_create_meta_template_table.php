<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%meta_template}}`.
 */
class m201211_084424_create_meta_template_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%meta_template}}', [
            'id' => $this->primaryKey(),
            'url' => $this->string(),
            'title' => $this->text(),
            'des' => $this->text(),
            'h1' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%meta_template}}');
    }
}
