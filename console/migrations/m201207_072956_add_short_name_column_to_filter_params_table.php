<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%filter_params}}`.
 */
class m201207_072956_add_short_name_column_to_filter_params_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('filter_params', 'short_name', $this->string(50)->comment('Имя класс без пространства имен'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('filter_params', 'short_name');
    }
}
