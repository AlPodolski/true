<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%national}}`.
 */
class m201207_141020_create_national_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%national}}', [
            'id' => $this->primaryKey(),
            'url' => $this->string(50),
            'value' => $this->string(50),
        ]);
        $this->execute('INSERT INTO `national` (`id`, `url`, `value`) VALUES
                            (1, \'uzbechka\', \'Узбечка\'),
                            (2, \'aziatka\', \'Азиатка\'),
                            (3, \'armyanka\', \'Армянка\'),
                            (4, \'mylatka\', \'Мулатка\'),
                            (5, \'negrityanka\', \'Негритянка\'),
                            (6, \'russkaya\', \'Русская\'),
                            (7, \'tadjichka\', \'Таджичка\'),
                            (8, \'taika\', \'Тайка\'),
                            (9, \'ukrainka\', \'Украинка\'),
                            (10, \'kitayanka\', \'Китаянка\'),
                            (11, \'amerikanka\', \'Американка\'),
                            (12, \'arabka\', \'Арабка\'),
                            (13, \'vetnamka\', \'Вьетнамка\'),
                            (14, \'cheshka\', \'Чешка\'),
                            (15, \'yaponka\', \'Японка\');');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%national}}');
    }
}
