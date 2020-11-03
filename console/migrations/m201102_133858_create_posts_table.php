<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%posts}}`.
 */
class m201102_133858_create_posts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%posts}}', [
            'id' => $this->primaryKey(),
            'city_id' => $this->smallInteger(),
            'user_id' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'name' => $this->string(60),
            'phone' => $this->string(20),
            'about' => $this->text(),
            'category' => $this->smallInteger(1),
            'selfie' => $this->smallInteger(1),
            'check_photo_status' => $this->smallInteger(1),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%posts}}');
    }
}
