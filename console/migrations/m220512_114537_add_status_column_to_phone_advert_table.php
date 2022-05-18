<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%phone_advert}}`.
 */
class m220512_114537_add_status_column_to_phone_advert_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('phones_advert',
            'status',
            $this->tinyInteger()->defaultValue(1)->unsigned()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('phones_advert','status' );
    }
}
