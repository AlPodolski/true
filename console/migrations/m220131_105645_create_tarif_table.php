<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tarif}}`.
 */
class m220131_105645_create_tarif_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tarif}}', [
            'id' => $this->primaryKey(),
            'value' => $this->string(),
            'sum' => $this->integer(),
        ]);

        $this->execute("
            INSERT INTO `tarif` (`value`, `sum`) VALUES
            ('Бесплатный', 0),
            ('Начальный', 1),
            ('VIP', 3),
            ('Premium', 5);
        ");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tarif}}');
    }
}
