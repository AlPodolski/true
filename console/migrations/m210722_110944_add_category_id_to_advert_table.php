<?php

use yii\db\Migration;

/**
 * Class m210722_110944_add_category_id_to_advert_table
 */
class m210722_110944_add_category_id_to_advert_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('advert', 'category_id', $this->integer());

        $this->addForeignKey(
            'fk_advert_category_id_to_advert_category',
            'advert',
            'category_id',
            'advert_category',
            'id',
            'SET NULL',
            'SET NULL'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('advert', 'category_id');
    }

}
