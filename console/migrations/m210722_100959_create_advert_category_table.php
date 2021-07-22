<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%advert_category}}`.
 */
class m210722_100959_create_advert_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%advert_category}}', [
            'id' => $this->primaryKey(),
            'value' => $this->string(),
        ]);

        $this->execute(
            "insert into `advert_category` (`value`) values
                ('Работа для девушек'),
                ('Услуги  фотографа'),
                ('Реклама'),
                ('Ищу напарницу'),
                ('Работа диспечера'),
                ('Аренда квартиры'),
                ('Массажистки'),
                ('Работа водителем'),
                ('Ищу работу'),
                ('Товары'),
                ('Ищу скаута'),
                ('Прочее')
              "
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%advert_category}}');
    }
}
