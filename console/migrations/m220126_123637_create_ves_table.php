<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%ves}}`.
 */
class m220126_123637_create_ves_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%ves}}', [
            'id' => $this->primaryKey(),
            'url' => $this->string(),
            'value' => $this->string(),
            'value2' => $this->string()
        ]);

        $this->execute("
        INSERT INTO `ves` (`id`, `url`, `value`, `value2`)
        VALUES (NULL, 'hudye', 'Худые', 'худых'), 
               (NULL, 'tolstye', 'Толстые', 'толстых');
        ");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%ves}}');
    }
}
