<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%national}}`.
 */
class m220122_093234_add_value2_column_to_national_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('national', 'value2', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('national', 'value2');
    }
}
