<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%posts}}`.
 */
class m210810_123920_add_pay_tyme_column_to_posts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('posts', 'pay_time', $this->integer()
            ->unsigned()
            ->defaultValue(0)
            ->comment('время в которое будет сделано след списание')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('posts', 'pay_time');
    }
}
