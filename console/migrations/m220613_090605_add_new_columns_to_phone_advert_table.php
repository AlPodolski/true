<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%phone_advert}}`.
 */
class m220613_090605_add_new_columns_to_phone_advert_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('phones_advert',
            'age',
            $this->tinyInteger()->defaultValue(1)->unsigned()
        );
        $this->addColumn('phones_advert',
            'rayon_id',
            $this->smallInteger()->unsigned()
        );
        $this->addColumn('phones_advert',
            'national_id',
            $this->tinyInteger()->unsigned()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('phones_advert', 'national_id');
        $this->dropColumn('phones_advert', 'rayon_id');
        $this->dropColumn('phones_advert', 'age');
    }
}
