<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%bill}}`.
 */
class m210322_113904_create_bill_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%bill}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->unsigned(),
            'status' => $this->tinyInteger()->unsigned()->comment('0 Счет выставлен, ожидает оплаты, 1 Счет оплачен , 2 Счет отклонен , 3 Время жизни счета истекло. Счет не оплачен'),
            'sum' => $this->smallInteger()->unsigned(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%bill}}');
    }
}
