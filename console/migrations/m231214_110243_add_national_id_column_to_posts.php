<?php

use yii\db\Migration;

/**
 * Class m231214_110243_add_national_id_column_to_posts
 */
class m231214_110243_add_national_id_column_to_posts extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('posts', 'national_id', $this->smallInteger()->defaultValue(null));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('posts', 'national_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m231214_110243_add_national_id_column_to_posts cannot be reverted.\n";

        return false;
    }
    */
}
