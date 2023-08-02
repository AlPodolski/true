<?php

use yii\db\Migration;

/**
 * Class m230801_072903_add_class_related_id_to_message_table
 */
class m230801_072903_add_class_related_id_to_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('message', 'class', $this->string());
        $this->addColumn('message', 'related_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('message', 'class');
        $this->dropColumn('message', 'related_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230801_072903_add_class_related_id_to_message_table cannot be reverted.\n";

        return false;
    }
    */
}
