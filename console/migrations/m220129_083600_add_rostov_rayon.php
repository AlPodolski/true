<?php

use yii\db\Migration;

/**
 * Class m220129_083600_add_rostov_rayon
 */
class m220129_083600_add_rostov_rayon extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $rayonList = array('Ворошиловский' =>  'voroshilovskij' , 'Железнодорожный' =>  'zheleznodorozhnyj' ,
            'Кировский' =>  'kirovskij' , 'Ленинский' =>  'leninskij' , 'Октябрьский' =>  'oktyabrskij' ,
            'Первомайский' =>  'pervomajskij' , 'Пролетарский' =>  'proletarskij' , 'Советский' =>  'sovetskij' );

        foreach ($rayonList as $key => $value){

            $rayon = new \common\models\Rayon();

            $rayon->city_id = 43;
            $rayon->url = $value;
            $rayon->value = $key;

            $rayon->save();

        }

        $postsList = \frontend\modules\user\models\Posts::find()->where(['city_id' => 43])->all();

        $dbRayonList = \common\models\Rayon::find()->where(['city_id' => 43])->all();

        foreach ($postsList as $post){

            \frontend\modules\user\models\UserRayon::deleteAll(['post_id' => $post['id']]);

            $userRayon = new \frontend\modules\user\models\UserRayon();

            $userRayon->post_id = $post['id'];
            $userRayon->city_id = 43;
            $userRayon->rayon_id = $dbRayonList[array_rand($dbRayonList)]['id'];

            $userRayon->save();

        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220129_083600_add_rostov_rayon cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220129_083600_add_rostov_rayon cannot be reverted.\n";

        return false;
    }
    */
}
