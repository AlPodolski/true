<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%phone_advert}}`.
 */
class m220512_115256_add_created_at_column_to_phone_advert_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('phones_advert', 'created_at', $this->integer()->unsigned());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('phones_advert', 'created_at');
    }
}
