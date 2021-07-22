<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%advert}}`.
 */
class m210721_070858_add_type_column_to_advert_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('advert', 'type', $this->tinyInteger()
            ->defaultValue(0)
            ->comment('0 объявление публичное 1 доступно только в кабинете')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('advert', 'type');
    }
}
