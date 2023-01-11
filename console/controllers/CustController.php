<?php


namespace console\controllers;

use common\models\City;
use common\models\Rayon;
use common\models\Redirect;
use common\models\User;
use frontend\models\Files;
use frontend\models\UserMetro;
use frontend\models\Webmaster;
use frontend\modules\user\models\Posts;
use frontend\modules\user\models\UserHairColor;
use frontend\modules\user\models\UserIntimHair;
use frontend\modules\user\models\UserNational;
use frontend\modules\user\models\UserPlace;
use frontend\modules\user\models\UserRayon;
use frontend\modules\user\models\UserService;
use League\Csv\Reader;
use League\Csv\Statement;
use Yii;
use yii\console\Controller;

class CustController extends Controller
{
    public function actionPrice()
    {
        $posts = Posts::find()
            ->where(['city_id' => '1'])
            ->andWhere(['fake' => Posts::POST_FAKE])
            ->limit(15000)
            ->all();

        foreach ($posts as $post){

            if ($postPhoto = Files::findAll(['related_id' => $post['id'], 'related_class' => Posts::class])){

                foreach ($postPhoto as $item){

                    $file = Yii::getAlias('@app/web'.$item->file);

                    if(\is_file($file)) \unlink($file);

                    $item->delete();

                }

            }

            UserRayon::deleteAll(['post_id' => $post['id']]);
            UserMetro::deleteAll(['post_id' => $post['id']]);
            UserHairColor::deleteAll(['post_id' => $post['id']]);
            UserIntimHair::deleteAll(['post_id' => $post['id']]);
            UserNational::deleteAll(['post_id' => $post['id']]);
            UserPLace::deleteAll(['post_id' => $post['id']]);
            UserService::deleteAll(['post_id' => $post['id']]);

            $post->delete();

        }

    }

    public function actionCust()
    {

        $cityList = City::find()->all();

        foreach ($cityList as $cityItem){

            $posts = Posts::find()
                ->where(['city_id' => $cityItem])
                ->with('photo')->all();

        }

        $posts = Posts::find()
            ->where(['<', 'pay_time', time() - (3600 * 24 * 7)])
            ->andWhere(['status' => Posts::POST_DONT_PUBLICATION_STATUS])
            ->andWhere(['fake' => Posts::POST_REAL])
            ->with('tarif')
            ->all();

        foreach ($posts as $post){

            $post->pay_time = time() + (3600 * 24 * 3);
            $post->status = Posts::POST_ON_PUPLICATION_STATUS;

            $post->save();

        }
    }

    public function actionIndex()
    {
        $stream = \fopen(Yii::getAlias('@app/files/add_city.csv'), 'r');

        $csv = Reader::createFromStream($stream);
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);
        //build a statement
        $stmt = (new Statement());

        $records = $stmt->process($csv);

        $city = array();

        foreach ($records as $record) {
            $city[] = $record;
        }

        foreach ($city as $item){

            $city = new City();

            $city->url = $item['url'];
            $city->city = $item['city'];
            $city->city2 = $item['city2'];
            $city->city3 = $item['city3'];
            $city->country = $item['country'];

            $city->save();

        }

    }
}