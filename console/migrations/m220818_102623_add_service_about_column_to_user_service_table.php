<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%user_service}}`.
 */
class m220818_102623_add_service_about_column_to_user_service_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user_service', 'service_info', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user_service', 'service_info');
    }
}
