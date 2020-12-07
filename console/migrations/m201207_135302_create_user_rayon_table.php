<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_rayon}}`.
 */
class m201207_135302_create_user_rayon_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_rayon}}', [
            'rayon_id' => $this->smallInteger()->unsigned(),
            'post_id' => $this->integer()->unsigned(),
            'city_id' => $this->tinyInteger()->unsigned()
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_rayon}}');
    }
}
