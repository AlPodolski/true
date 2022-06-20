<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%claim}}`.
 */
class m220620_063830_add_email_and_comercial_column_to_claim_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('anket_claim', 'offer', $this->boolean()->defaultValue(0));
        $this->addColumn('anket_claim', 'email', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('anket_claim', 'offer');
        $this->dropColumn('anket_claim', 'email');
    }
}
