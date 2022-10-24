<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%claim}}`.
 */
class m221024_053746_add_ip_column_to_claim_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('claim', 'ip', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('claim', 'ip');
    }
}
