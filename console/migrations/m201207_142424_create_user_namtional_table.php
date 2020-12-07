<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_namtional}}`.
 */
class m201207_142424_create_user_namtional_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_national}}', [
            'post_id' => $this->integer(),
            'national_id' => $this->tinyInteger(),
            'city_id' => $this->tinyInteger(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_national}}');
    }
}
