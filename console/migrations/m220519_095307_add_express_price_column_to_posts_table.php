<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%posts}}`.
 */
class m220519_095307_add_express_price_column_to_posts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('posts', 'express_price', $this->smallInteger()->unsigned());
        $this->addColumn('posts', 'price_2_hour', $this->integer()->unsigned());
        $this->addColumn('posts', 'price_night', $this->integer()->unsigned());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('posts', 'express_price');
        $this->dropColumn('posts', 'price_2_hour');
        $this->dropColumn('posts', 'price_night');
    }
}
