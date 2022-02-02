<?php


namespace console\controllers;

use common\models\City;
use common\models\Rayon;
use frontend\modules\user\models\Posts;
use League\Csv\Reader;
use League\Csv\Statement;
use Yii;
use yii\console\Controller;

class CustController extends Controller
{
    public function actionIndex()
    {
        $stream = \fopen(Yii::getAlias('@app/files/rf_rayons.csv'), 'r');

        $csv = Reader::createFromStream($stream);
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);
        //build a statement
        $stmt = (new Statement());

        $records = $stmt->process($csv);

        $rayonList = [];

        foreach ($records as $record) {

            $rayonList[] = $record;

        }

        foreach ($rayonList as $rayonItem){

            if ($cityInfo = City::find()->where(['city' => $rayonItem['city']])->one()){

                if (!Rayon::findOne(['city_id' => $cityInfo['id'], 'value' => $rayonItem['value']])){

                    $newRayon = new Rayon();

                    $newRayon->value = $rayonItem['value'];
                    $newRayon->url = $rayonItem['url'];
                    $newRayon->city_id = $cityInfo['id'];

                    $newRayon->save();

                }

            }

        }

    }
}