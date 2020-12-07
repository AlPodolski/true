<?php

use yii\db\Migration;

/**
 * Class m201207_113320_add_city_id_to_user_service_table
 */
class m201207_113320_add_city_id_to_user_service_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('user_service', 'city_id', $this->tinyInteger()->unsigned());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('user_service', 'city_id');
    }

}
