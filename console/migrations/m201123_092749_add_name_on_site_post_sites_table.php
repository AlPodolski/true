<?php

use yii\db\Migration;

/**
 * Class m201123_092749_add_name_on_site_post_sites_table
 */
class m201123_092749_add_name_on_site_post_sites_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('post_sites', 'name_on_site', $this->string(50));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('post_sites', 'name_on_site');
    }

}
