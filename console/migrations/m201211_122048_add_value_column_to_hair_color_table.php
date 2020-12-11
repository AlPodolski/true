<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%hair_color}}`.
 */
class m201211_122048_add_value_column_to_hair_color_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('hair_color', 'value2', $this->string(55));
        $this->addColumn('hair_color', 'value3', $this->string(55));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('hair_color', 'value2');
        $this->dropColumn('hair_color', 'value3');
    }
}
