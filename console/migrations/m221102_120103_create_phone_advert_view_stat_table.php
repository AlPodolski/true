<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%phone_advert_view_stat}}`.
 */
class m221102_120103_create_phone_advert_view_stat_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%phone_advert_view_stat}}', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer(),
            'last_view' => $this->integer(),
            'count_view' => $this->integer(),
        ]);

        $this->addForeignKey('phone_advert_count_foreign_key',
            'phone_advert_view_stat',
            'post_id',
            'posts',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%phone_advert_view_stat}}');
    }
}
