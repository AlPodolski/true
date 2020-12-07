<?php

use yii\db\Migration;

/**
 * Class m201207_114503_add_city_id_to_user_place_table
 */
class m201207_114503_add_city_id_to_user_place_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user_place', 'city_id', $this->tinyInteger()->unsigned());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user_place', 'city_id');
    }

}
