<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%obmenka_oreder}}`.
 */
class m241106_084134_add_payment_system_column_to_obmenka_oreder_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('obmenka_order', 'payment_system', $this->tinyInteger()->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('obmenka_order', 'payment_system');
    }
}
