<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%request_call}}`.
 */
class m210624_121934_add_status_column_to_request_call_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('request_call', 'status', $this->tinyInteger()
            ->defaultValue(0)
            ->comment('0 заявка не просмотрена, 1 просмотрена, 2 заявка скрыта'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('request_call', 'status');
    }
}
