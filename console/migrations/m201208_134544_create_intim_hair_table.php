<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%intim_hair}}`.
 */
class m201208_134544_create_intim_hair_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%intim_hair}}', [
            'id' => $this->primaryKey(),
            'url' => $this->string(50),
            'value' => $this->string(50),
            'value2' => $this->string(50),
            'value3' => $this->string(50),
        ]);

        $this->execute("
                        INSERT INTO `intim_hair` ( `url`, `value`, `value2`, `value3`) VALUES
                        ( 'polnaya-depilyaciya', 'с полной  депиляцией', NULL, NULL),
                        ( 'akkuratnaya-strizhka', 'с акуратной стрижкой', NULL, NULL),
                        ( 'naturalnaya', 'с натуральной растительностью', NULL, NULL);
        ");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%intim_hair}}');
    }
}
