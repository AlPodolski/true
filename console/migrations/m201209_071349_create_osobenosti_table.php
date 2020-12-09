<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%osobenosti}}`.
 */
class m201209_071349_create_osobenosti_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%osobenosti}}', [
            'id' => $this->primaryKey(),
            'url' => $this->string(50),
            'value' => $this->string(50),
            'value2' => $this->string(50),
            'value3' => $this->string(50),
        ]);

        $this->execute("
            INSERT INTO `osobenosti` ( `url`, `value`, `value2`, `value3`) VALUES
            ( 'beremennie', 'беременные', NULL, NULL),
            ( 'sbolshimklitirom', 'с большим клитором', NULL, NULL),
            ( 'jopastie', 'жопастые', NULL, NULL),
            ( 'taty', 'тату', NULL, NULL),
            ( 'krasivie', 'Красивые', NULL, NULL),
            ( 'trans', 'Транс', NULL, NULL),
            ( 'okonchanie-na-grud', 'Окончание на грудь', NULL, NULL),
            ( 'okonchanie-na-lico', 'Окончание на лицо', NULL, NULL),
            ( 'okonchanie-v-rot', 'Окончание в рот', NULL, NULL),
            ( 'lesbi-shou', 'Лесби-шоу', NULL, NULL),
            ( 'bandazh', 'Бандаж', NULL, NULL);
        ");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%osobenosti}}');
    }
}
