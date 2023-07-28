<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%obmenka_order}}`.
 */
class m230728_100142_add_link_column_to_obmenka_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('obmenka_order', 'link', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('obmenka_order', 'link');
    }
}
