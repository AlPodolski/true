<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%advert}}`.
 */
class m210722_071901_add_status_column_to_advert_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('advert', 'status', $this->tinyInteger()
            ->defaultValue(0)
            ->comment('0 объявление не проверенно 1 проверенно'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('advert', 'status');
    }
}
