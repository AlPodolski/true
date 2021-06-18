<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%anket_claim}}`.
 */
class m210618_053503_create_anket_claim_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%anket_claim}}', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer(),
            'reason_id' => $this->integer(),
            'text' => $this->string(),
        ]);

        $this->addForeignKey('fk-anket_claim_reason_id_reason_claim_id', 'anket_claim', 'reason_id',
            'reason_claim', 'id', 'CASCADE', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%anket_claim}}');
    }
}
