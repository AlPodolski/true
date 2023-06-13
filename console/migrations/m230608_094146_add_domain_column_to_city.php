<?php

use yii\db\Migration;

/**
 * Class m230608_094146_add_domain_column_to_city
 */
class m230608_094146_add_domain_column_to_city extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('city', 'domain', $this->string(122));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('city', 'domain');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230608_094146_add_domain_column_to_city cannot be reverted.\n";

        return false;
    }
    */
}
