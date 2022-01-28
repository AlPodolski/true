<?php

use yii\db\Migration;

/**
 * Class m220128_125019_add_spb_metro
 */
class m220128_125019_add_spb_metro extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $metroList = array(
            'Девяткино' => 'devyatkino', 'Гражданский проспект' => 'grazhdanskij-prospekt',
            'Академическая' => 'akademicheskaya', 'Политехническая' => 'politekhnicheskaya',
            'Площадь Мужества' => 'ploshchad-muzhestva', 'Лесная' => 'lesnaya', 'Выборгская' => 'vyborgskaya',
            'Площадь Ленина' => 'ploshchad-lenina', 'Чернышевская' => 'chernyshevskaya',
            'Площадь Восстания' => 'ploshchad-vosstaniya', 'Владимирская' => 'vladimirskaya',
            'Пушкинская' => 'pushkinskaya', 'Технологический институт' => 'tekhnologicheskij-institut',
            'Балтийская' => 'baltijskaya', 'Нарвская' => 'narvskaya', 'Кировский завод' => 'kirovskij-zavod',
            'Автово' => 'avtovo', 'Ленинский проспект' => 'leninskij-prospekt',
            'Проспект Ветеранов' => 'prospekt-veteranov', 'Парнас' => 'parnas',
            'Проспект Просвещения' => 'prospekt-prosveshcheniya', 'Озерки' => 'ozerki',
            'Удельная' => 'udelnaya', 'Пионерская' => 'pionerskaya',
            'Чёрная речка' => 'chyornaya-rechka', 'Петроградская' => 'petrogradskaya',
            'Горьковская' => 'gorkovskaya', 'Невский проспект' => 'nevskij-prospekt',
            'Сенная площадь' => 'sennaya-ploshchad',
            'Фрунзенская' => 'frunzenskaya', 'Московские ворота' => 'moskovskie-vorota', 'Электросила' => 'ehlektrosila',
            'Парк Победы' => 'park-pobedy', 'Московская' => 'moskovskaya', 'Звёздная' => 'zvyozdnaya',
            'Купчино' => 'kupchino', 'Беговая' => 'begovaya', 'Зенит' => 'zenit', 'Приморская' => 'primorskaya',
            'Василеостровская' => 'vasileostrovskaya', 'Гостиный двор' => 'gostinyj-dvor', '
            Маяковская' => 'mayakovskaya', 'Площадь Александра Невского' => 'ploshchad-aleksandra-nevskogo',
            'Елизаровская' => 'elizarovskaya', 'Ломоносовская' => 'lomonosovskaya', 'Пролетарская' => 'proletarskaya',
            'Обухово' => 'obuhovo', 'Рыбацкое' => 'rybackoe', 'Спасская' => 'spasskaya', 'Достоевская' => 'dostoevskaya',
            'Лиговский проспект' => 'ligovskij-prospekt',
            'Новочеркасская' => 'novocherkasskaya', 'Ладожская' => 'ladozhskaya',
            'Проспект Большевиков' => 'prospekt-bolshevikov', 'Улица Дыбенко' => 'ulica-dybenko',
            'Комендантский проспект' => 'komendantskij-prospekt', 'Старая Деревня' => 'staraya-derevnya',
            'Крестовский остров' => 'krestovskij-ostrov', 'Чкаловская' => 'chkalovskaya',
            'Спортивная' => 'sportivnaya', 'Адмиралтейская' => 'admiraltejskaya',
            'Садовая' => 'sadovaya', 'Звенигородская' => 'zvenigorodskaya',
            'Обводный канал' => 'obvodnyj-kanal', 'Волковская' => 'volkovskaya', 'Бухарестская' => 'buharestskaya',
            'Международная' => 'mezhdunarodnaya', 'Проспект Славы' => 'prospekt-slavy', 'Дунайская' => 'dunajskaya',
            'Шушары' => 'shushary',
        );

        foreach ($metroList as $key => $value){

            $metro = new \frontend\models\Metro();

            $metro->city_id = 161;
            $metro->url = $value;
            $metro->value = $key;

            $metro->save();

        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220128_125019_add_spb_metro cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220128_125019_add_spb_metro cannot be reverted.\n";

        return false;
    }
    */
}
