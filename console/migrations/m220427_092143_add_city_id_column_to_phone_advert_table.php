<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%phone_advert}}`.
 */
class m220427_092143_add_city_id_column_to_phone_advert_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('phones_advert', 'city_id', $this->smallInteger()->defaultValue(1)->unsigned());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('phones_advert', 'city_id');
    }
}
