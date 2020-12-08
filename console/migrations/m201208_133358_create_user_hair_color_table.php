<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_hair_color}}`.
 */
class m201208_133358_create_user_hair_color_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_hair_color}}', [
            'post_id' => $this->integer(),
            'hair_color_id' => $this->tinyInteger(),
            'city_id' => $this->tinyInteger(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_hair_color}}');
    }
}
