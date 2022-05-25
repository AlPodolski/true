<?php

use yii\db\Migration;

/**
 * Class m220525_053913_add_city_name_to_yandex_tag_table
 */
class m220525_053913_add_city_name_to_yandex_tag_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('webmaster', 'city_name', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('webmaster', 'city_name');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220525_053913_add_city_name_to_yandex_tag_table cannot be reverted.\n";

        return false;
    }
    */
}
