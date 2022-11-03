<?php

use yii\db\Migration;

/**
 * Class m221102_134142_add_last_phone_view_and_phone_advert_view_count_to_posts_table
 */
class m221102_134142_add_last_phone_view_and_phone_advert_view_count_to_posts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('posts', 'last_phone_view_at', $this->integer()->defaultValue(0));
        $this->addColumn('posts', 'advert_phone_view_count', $this->tinyInteger()->unsigned()->defaultValue(48));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('posts', 'last_phone_view_at');
        $this->dropColumn('posts', 'advert_phone_view_count');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221102_134142_add_last_phone_view_and_phone_advert_view_count_to_posts_table cannot be reverted.\n";

        return false;
    }
    */
}
