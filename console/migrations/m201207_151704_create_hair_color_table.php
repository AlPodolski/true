<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%hair_color}}`.
 */
class m201207_151704_create_hair_color_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%hair_color}}', [
            'id' => $this->primaryKey(),
            'url' => $this->string(50),
            'value' => $this->string(50),
        ]);

        $this->execute(
            "
            INSERT INTO `hair_color` (`url`, `value`) VALUES
             ('blondinka', 'Блондинка'),
             ('brunetka', 'Брюнетка'),
             ('rysaya', 'Русая'),
             ('rijaya', 'Рыжая'),
             ('shatenka', 'Шатенка')
            "
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%hair_color}}');
    }
}
