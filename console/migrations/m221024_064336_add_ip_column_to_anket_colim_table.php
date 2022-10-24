<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%anket_colim}}`.
 */
class m221024_064336_add_ip_column_to_anket_colim_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('anket_claim', 'ip', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('anket_claim', 'ip');
    }
}
