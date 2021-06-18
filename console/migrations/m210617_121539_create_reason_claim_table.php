<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%reason_claim}}`.
 */
class m210617_121539_create_reason_claim_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%reason_claim}}', [
            'id' => $this->primaryKey(),
            'value' => $this->string(),
        ]);

        $this->execute('INSERT INTO `reason_claim` ( `value` ) VALUES ("Телефон отключён") , 
                                               ("Не берут трубку") , 
                                               ("Ошиблись номером") , 
                                               ("Грубо общается" ),
                                               ("Фото не её"),
                                               ("Другое") ');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%reason_claim}}');
    }
}
