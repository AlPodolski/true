<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%link}}`.
 */
class m210723_110719_add_city_id_column_to_link_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('link', 'city_id', $this->tinyInteger()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('link', 'city_id');
    }
}
