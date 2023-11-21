<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%cloud_info}}`.
 */
class m231121_122033_add_domain_column_to_cloud_info_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('cloud_info', 'domain', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('cloud_info', 'domain');
    }
}
