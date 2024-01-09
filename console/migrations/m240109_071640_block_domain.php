<?php

use yii\db\Migration;

/**
 * Class m240109_071640_block_domain
 */
class m240109_071640_block_domain extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%block_domain}}', [
            'id' => $this->primaryKey(),
            'domain' => $this->string(),
            'created_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240109_071640_block_domain cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240109_071640_block_domain cannot be reverted.\n";

        return false;
    }
    */
}
