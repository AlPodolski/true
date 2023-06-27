<?php

use yii\db\Migration;

/**
 * Class m230627_094749_add_type_to_service_table
 */
class m230627_094749_add_type_to_service_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('service', 'type', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('service', 'type');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230627_094749_add_type_to_service_table cannot be reverted.\n";

        return false;
    }
    */
}
