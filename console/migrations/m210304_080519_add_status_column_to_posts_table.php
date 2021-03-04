<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%posts}}`.
 */
class m210304_080519_add_status_column_to_posts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('posts', 'status', $this->tinyInteger()
            ->unsigned()
            ->defaultValue(0)
            ->comment('Статус публикации анкеты, 0 на модерации, 1 публикуется 2 не публикуется'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('posts', 'status');
    }
}
