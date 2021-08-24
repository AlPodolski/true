<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%pol}}`.
 */
class m210824_055936_create_pol_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%pol}}', [
            'id' => $this->primaryKey(),
            'value' => $this->string(),
            'url' => $this->string()
        ]);

        $this->execute("
        INSERT INTO `pol` (`value`, `url`) VALUES ('Мужской', 'muzhskoj'), ('Женский', 'zhenskij'), ('Транс', 'trans')
        ");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%pol}}');
    }
}
