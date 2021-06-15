<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%obmenka_order}}`.
 */
class m210615_095247_add_pay_info_column_to_obmenka_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('obmenka_order', 'pay_info', $this->tinyInteger()->unsigned());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('obmenka_order', 'pay_info');
    }
}
