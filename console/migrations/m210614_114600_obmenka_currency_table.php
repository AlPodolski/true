<?php

use yii\db\Migration;

/**
 * Class m210614_114600_obmenka_currency_table
 */
class m210614_114600_obmenka_currency_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%obmenka_currency}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(25),
            'value' => $this->string(25),
        ]);

        $this->execute('INSERT INTO `obmenka_currency` ( `name` , `value` ) VALUES ("QIWI" , "qiwi")');
        $this->execute('INSERT INTO `obmenka_currency` ( `name` , `value` ) VALUES ("Visa_Master" , "visamaster.rur")');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%obmenka_currency}}');
    }
}
