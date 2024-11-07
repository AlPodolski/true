<?php

use yii\db\Migration;

/**
 * Class m241106_084604_add_payment_system_to_obmenka_currency_table
 */
class m241106_084604_add_payment_system_to_obmenka_currency_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('obmenka_currency', 'payment_system', $this->tinyInteger()->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('obmenka_currency', 'payment_system');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241106_084604_add_payment_system_to_obmenka_currency_table cannot be reverted.\n";

        return false;
    }
    */
}
