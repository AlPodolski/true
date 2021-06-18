<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%anket_claim}}`.
 */
class m210618_074604_add_created_at_updated_at_columns_to_anket_claim_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('anket_claim', 'created_at', $this->integer()->unsigned());
        $this->addColumn('anket_claim', 'updated_at', $this->integer()->unsigned());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('anket_claim', 'created_at');
        $this->dropColumn('anket_claim', 'updated_at');
    }
}
