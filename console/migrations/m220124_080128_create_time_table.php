<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%time}}`.
 */
class m220124_080128_create_time_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%time}}', [
            'id' => $this->primaryKey(),
            'url' => $this->string(),
            'value' => $this->string()
        ]);

        $this->execute("
            INSERT INTO `time` ( `url`, `value`) VALUES
            ('na-chas', 'На час'),
            ('na-noch', 'На ночь'),
            ('kruglosutochno', 'Круглосуточно');
        ");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%time}}');
    }
}
