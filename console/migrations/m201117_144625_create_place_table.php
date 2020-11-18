<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%place}}`.
 */
class m201117_144625_create_place_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%place}}', [
            'id' => $this->primaryKey(),
            'value' => $this->string(50),
            'url' => $this->string(50),
        ]);

        $this->execute("
            INSERT INTO `place` (`value`, `url`) VALUES
            ( 'в апартаментах', 'appartamentu'),
            ( 'на  выезде', 'viezd'),
            ( 'В машине', 'v-mashine'),
            ( 'В сауне', 'v-sayne'),
            ( 'На дому', 'na-domu'),
            ( 'В клубе', 'v-klube'),
            ( 'По вызову', 'po-vizovu'),
            ( 'На дорогах', 'na-doroge');
        ");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%place}}');
    }
}
