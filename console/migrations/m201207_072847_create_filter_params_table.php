<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%filter_params}}`.
 */
class m201207_072847_create_filter_params_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%filter_params}}', [
            'id' => $this->primaryKey(),
            'url' => $this->string(100)->comment('урл который нужно связать с классом параметров'),
            'class_name' => $this->string(100)->comment('имя класса к которому относиться свойство с нейспекйсом'),
            'relation_class' => $this->string(100)->comment('имя класса в котором храниться связь между параметром и пользователем'),
            'column_param_name' => $this->string(100)->comment('Имя искомой колонки'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%filter_params}}');
    }
}
