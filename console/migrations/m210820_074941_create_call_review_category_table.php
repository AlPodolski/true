<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%call_review_category}}`.
 */
class m210820_074941_create_call_review_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%call_review_category}}', [
            'id' => $this->primaryKey(),
            'value' => $this->string(),
            'marc' => $this->tinyInteger()->comment('числовое значение категории отзыва'),
        ]);

        $this->execute(
            'INSERT INTO `call_review_category` (`value`, `marc`) VALUES 
                                                            ("Описание соответствует", 1), 
                                                            ("Описание не соответствует", 0), 
                                                            ("Номер не отвечает", -1), 
                                                            ("Номер указан неверно", -1)
                                                            '
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%call_review_category}}');
    }
}
