<?php

use yii\db\Migration;

/**
 * Class m201123_093352_add_age_to_posts_site_table
 */
class m201123_093352_add_age_to_posts_site_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('post_sites', 'age', $this->tinyInteger()->unsigned());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('post_sites', 'age');
    }

}
