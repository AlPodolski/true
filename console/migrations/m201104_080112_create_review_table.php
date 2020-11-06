<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%review}}`.
 */
class m201104_080112_create_review_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%review}}', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer(),
            'text' => $this->text(),
            'photo_marc' => $this->smallInteger(2),
            'total_marc' => $this->smallInteger(2),
            'clean' => $this->smallInteger(2),
        ]);



    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%review}}');
    }
}
