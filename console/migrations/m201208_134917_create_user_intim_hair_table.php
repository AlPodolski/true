<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_intim_hair}}`.
 */
class m201208_134917_create_user_intim_hair_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_intim_hair}}', [
            'post_id' => $this->integer(),
            'color_id' => $this->tinyInteger(),
            'city_id' => $this->tinyInteger(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_intim_hair}}');
    }
}
