<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%rost}}`.
 */
class m220126_112143_create_rost_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%rost}}', [
            'id' => $this->primaryKey(),
            'url' => $this->string(),
            'value' => $this->string(),
            'value2' => $this->string(),
        ]);

        $this->execute("
                    INSERT INTO `rost` (`url`, `value`, `value2`) VALUES
            ( 'visokii', 'Высокие', NULL),
            ( 'srednii', 'Среднего роста', NULL),
            ( 'nizkii', 'Низкие', NULL);
        ");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%rost}}');
    }
}
