<?php

use yii\db\Migration;

/**
 * Class m201207_083355_add_city_id_to_user_metro_table
 */
class m201207_083355_add_city_id_to_user_metro_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user_metro', 'city_id', $this->tinyInteger());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user_metro', 'city_id');
    }

}
