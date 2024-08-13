<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%obmenka_order}}`.
 */
class m240813_093040_add_tracking_id_column_to_obmenka_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('obmenka_order', 'tracking_id', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('obmenka_order', 'tracking_id');
    }
}
