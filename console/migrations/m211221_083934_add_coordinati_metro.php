<?php

use yii\db\Migration;

/**
 * Class m211221_083934_add_coordinati_metro
 */
class m211221_083934_add_coordinati_metro extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $metroList = \frontend\models\Metro::find()->all();

        $metroCoord = include Yii::getAlias('@app/files/metro_coordintata.php');

        foreach ($metroList as $metroItem){

            foreach ($metroCoord as $key => $item){

                if ($metroItem['value'] == $key){

                    $tempData = \explode(',', $item);

                    $metroItem->x = $tempData[0];
                    $metroItem->y = \trim($tempData[1]);

                    $metroItem->save();

                }

            }

        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211221_083934_add_coordinati_metro cannot be reverted.\n";

        return false;
    }

}
