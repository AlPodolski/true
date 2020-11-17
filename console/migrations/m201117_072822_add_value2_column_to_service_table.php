<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%service}}`.
 */
class m201117_072822_add_value2_column_to_service_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('service', 'value2', $this->string(50));

        $this->execute("
                        INSERT INTO `service` (`value`, `url`, `value2`) VALUES
            ( 'Госпожа', 'gospogha',   'Госпожи'),
            ( 'Легкая доминация', 'legkaya-dominaciya',   'Легкой доминации'),
            ( 'Ролевые игры', 'rolevye-igry',   'Ролевых игр'),
            ( 'Страпон', 'strapon',   'Страпона'),
            ( 'Фистинг анальный', 'fisting-analynyy',   'анального фистинга'),
            ( 'Фистинг классический', 'fisting-klassicheskiy',   'классического фистинга'),
            ( 'Минет в машине', 'minet-v-mashine',   'Минета в машине'),
            ( 'Минет глубокий', 'minet-glubokiy',   'глубокого минета'),
            ( 'Золотой дождь', 'zolotoy-doghdy',   'Золотого дождя'),
            ( 'Копро', 'kopro',   'Копро'),
            ( 'Анилингус', 'anilingus',   'Анилингуса'),
            ( 'Кунилингус', 'kunilingus',   'Кунилингуса'),
            ( 'Стриптиз', 'striptiz',   'Стриптиза'),
            ( 'Боди массаж', 'bodi-massagh',   'Боди массажа'),
            ( 'Ветка сакуры', 'vetka-sakury',   'Ветки сакуры'),
            ( 'Массаж простаты', 'massagh-prostaty',   'Массажа простаты'),
            ( 'Урологический массаж', 'urologicheskiy',   'Урологического массажа'),
            ( 'Эротический массаж', 'eroticheskiy',   'Эротического массажа'),
            ( 'Секс классический', 'klasijeskiy',   'классического секса'),
            ( 'Анальный секс', 'analnyj-seks',   'Анального секса'),
            ( 'Минет в презервативе', 'minet-v-prezervative',   'Минета в презервативе'),
            ( 'Минет без резинки', 'minet-bez-rezinki',   'Минета без резинки'),
            ( 'Окончание на грудь', 'okonchanie-na-grud',   'Окончания на грудь'),
            ( 'Окончание на лицо', 'okonchanie-na-lico',   'Окончания на лицо'),
            ( 'Окончание в рот', 'okonchanie-v-rot',   'Окончания в рот'),
            ( 'Лесби-шоу', 'lesbi-shou',   'Лесби-шоу'),
            ( 'Бандаж', 'bandazh',   'Бандажа'),
            ( 'Рабыня', 'rabynya',   'Рабыни'),
            ( 'Эскорт', 'eskort',   'Эскорта'),
            ( 'Господин', 'gospodin',   'Господина'),
            ( 'Раб', 'rab',   'Раба'),
            ( 'БДСМ', 'bdsm',   'БДСМа');
        ");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
