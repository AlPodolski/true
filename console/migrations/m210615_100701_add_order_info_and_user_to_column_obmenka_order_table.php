<?php

use yii\db\Migration;

/**
 * Class m210615_100701_add_order_info_and_user_to_column_obmenka_order_table
 */
class m210615_100701_add_order_info_and_user_to_column_obmenka_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('obmenka_order', 'user_to', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('obmenka_order', 'user_to');
    }
}
