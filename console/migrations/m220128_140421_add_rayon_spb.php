<?php

use yii\db\Migration;

/**
 * Class m220128_140421_add_rayon_spb
 */
class m220128_140421_add_rayon_spb extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $rayonList = array(
            'Адмиралтейский' =>  'admiraltejskij' , 'Василеостровский' =>  'vasileostrovskij' ,
            'Выборгский' =>  'vyborgskij' , 'Калининский' =>  'kalininskij' , 'Кировский' =>  'kirovskij' ,
            'Колпинский' =>  'kolpinskij' , 'Красногвардейский' =>  'krasnogvardejskij' ,
            'Красносельский' =>  'krasnoselskij' , 'Кронштадтский' =>  'kronshtadtskij' ,
            'Курортный' =>  'kurortnyj' , 'Московский' =>  'moskovskij' , 'Невский' =>  'nevskij' ,
            'Петроградский' =>  'petrogradskij' , 'Петродворцовый' =>  'petrodvorcovyj' ,
            'Приморский' =>  'primorskij' , 'Пушкинский' =>  'pushkinskij' , 'Фрунзенский' =>  'frunzenskij' ,
            'Центральный' =>  'centralnyj');

        foreach ($rayonList as $key => $value){

            $metro = new \common\models\Rayon();

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
        echo "m220128_140421_add_rayon_spb cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220128_140421_add_rayon_spb cannot be reverted.\n";

        return false;
    }
    */
}
