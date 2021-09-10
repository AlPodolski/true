<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%advert}}`.
 */
class m210910_103629_add_id_from_parse_site_column_to_advert_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('advert', 'id_from_parse_site', $this->integer()->unsigned());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('advert', 'id_from_parse_site');
    }
}
