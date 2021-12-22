<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%metro}}`.
 */
class m211221_082855_add_x_y_column_to_metro_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('metro', 'x', $this->float());
        $this->addColumn('metro', 'y', $this->float());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('metro', 'x');
        $this->dropColumn('metro', 'y');
    }
}
