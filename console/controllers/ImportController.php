<?php

namespace console\controllers;

use common\models\Link;
use common\models\PhonesAdvert;
use dastanaron\translit\Translit;
use common\models\City;
use common\models\HairColor;
use common\models\National;
use common\models\Osobenosti;
use common\models\Place;
use common\models\Rayon;
use common\models\Service;
use common\models\User;
use frontend\models\Files;
use frontend\models\Metro;
use frontend\models\UserMetro;
use frontend\models\Webmaster;
use frontend\modules\advert\models\Advert;
use frontend\modules\user\models\Posts;
use frontend\modules\user\models\PostSites;
use frontend\modules\user\models\Review;
use frontend\modules\user\models\ServiceDesc;
use frontend\modules\user\models\ServiceReviews;
use frontend\modules\user\models\UserHairColor;
use frontend\modules\user\models\UserIntimHair;
use frontend\modules\user\models\UserNational;
use frontend\modules\user\models\UserOsobenosti;
use frontend\modules\user\models\UserPlace;
use frontend\modules\user\models\UserRayon;
use frontend\modules\user\models\UserService;
use League\Csv\Reader;
use League\Csv\Statement;
use Yii;
use yii\base\BaseObject;
use yii\console\Controller;
use yii\helpers\ArrayHelper;

class ImportController extends Controller
{

    public $siteId;
    public $path;
    public $update;

    public function actionIndex()
    {

        $stream = \fopen(Yii::getAlias('@app/files/import_spb.csv'), 'r');

        $csv = Reader::createFromStream($stream);
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);
        $translit = new Translit();
        //build a statement
        $stmt = (new Statement());

        $records = $stmt->process($csv);

        $placeList = Place::find()->asArray()->all();

        $serviceList = Service::find()->asArray()->all();

        $this->siteId = 0;
        $this->update = 30;
        $this->path = '/uploads/a39/';

        $posts = array();

        $i = 0;

        foreach ($records as $record) {

            $posts[] = $record;

        }

        foreach ($posts as $record) {

            $city['id'] = 161;

            $post = new Posts();

            $post->price = $record['price'] ?? 6000;

            $post->city_id = $city['id'];
            $post->user_id = 241;
            $post->pol_id = 1;
            $post->created_at = \time();
            $post->name = $record['name'];
            $post->updated_at = $this->update;
            $post->phone = $record['phone'];
            $post->about = strip_tags($record['deskr']);
            $post->check_photo_status = 0;
            $post->status = 1;
            $post->sort = 10000;
            $post->age = $record['age'] ?? 19;
            $post->rost = $record['rost'] ?? 170;
            $post->ves = $record['weight'] ?? 53;

            if (isset($record['video']) and $record['video']) {
                $post->video = $this->path . $record['video'];
            }

            if (isset($record['grud']) and $record['grud']) $post->breast = $record['grud'];

            if (isset($record['ves']) and $record['ves']) $post->ves = (int)$record['ves'];

            $post->category = Posts::INDI_CATEGORY;

            if (isset($record['cheked']) and $record['cheked'] == 1) $post->check_photo_status = 1;

            if ($post->save()) {

                if (isset($record['rayon']) and $record['rayon'] and false) {

                    $rayonId = ArrayHelper::getValue(Rayon::find()
                        ->where(['value' => $record['rayon']])
                        ->andWhere(['city_id' => $city['id']])
                        ->asArray()->one(), 'id');

                    if ($rayonId) {

                        $userRayon = new UserRayon();
                        $userRayon->post_id = $post->id;
                        $userRayon->rayon_id = $rayonId;
                        $userRayon->city_id = $city['id'];
                        $userRayon->save();

                    }

                }

                if (isset($record['metro']) and $metro = $record['metro'] and false) {

                    if ($metro) {

                        $id = ArrayHelper::getValue(Metro::find()->where(['value' => $metro])->asArray()->one(), 'id');

                        if ($id) {

                            $userRayon = new UserMetro();
                            $userRayon->post_id = $post->id;
                            $userRayon->metro_id = $id;
                            $userRayon->city_id = $city['id'];
                            $userRayon->save();

                        }

                    }

                }

                if (isset($record['hair']) and $record['hair']) {

                    $id = ArrayHelper::getValue(HairColor::find()->where(['value2' => $record['hair']])->asArray()->one(), 'id');

                    if ($id) {

                        $userRayon = new UserHairColor();
                        $userRayon->post_id = $post->id;
                        $userRayon->hair_color_id = $id;
                        $userRayon->city_id = $city['id'];
                        $userRayon->save();

                    }

                }

                if (isset($record['ethnik']) and $record['ethnik']) {

                    $id = ArrayHelper::getValue(National::find()->where(['value2' => $record['ethnik']])->asArray()->one(), 'id');

                    if ($id) {

                        $userRayon = new UserNational();
                        $userRayon->post_id = $post->id;
                        $userRayon->national_id = $id;
                        $userRayon->city_id = $city['id'];
                        $userRayon->save();

                    }

                }

                foreach ($placeList as $placeItem) {

                    if (\rand(0, 2) == 1) {

                        $userRayon = new UserPlace();
                        $userRayon->post_id = $post->id;
                        $userRayon->place_id = $placeItem['id'];
                        $userRayon->city_id = $city['id'];
                        $userRayon->save();

                    }

                }

                foreach ($serviceList as $serviceItem) {

                    if (\rand(0, 3) == 3) {

                        $userRayon = new UserService();
                        $userRayon->post_id = $post->id;
                        $userRayon->service_id = $serviceItem['id'];
                        $userRayon->city_id = $city['id'];
                        $userRayon->save();

                    }

                }

                if (isset($record['mini']) and $record['mini']) {

                    $userPhoto = new Files();

                    $userPhoto->related_id = $post->id;
                    $userPhoto->file = $this->path . $record['mini'];
                    $userPhoto->main = 1;
                    $userPhoto->type = 0;
                    $userPhoto->related_class = Posts::class;

                    $userPhoto->save();

                }

                if (isset($record['gallery']) and $record['gallery']) {

                    $gall = \explode(',', $record['gallery']);

                    if ($gall) {

                        foreach ($gall as $gallitem) {

                            if ($gallitem) {

                                $userPhoto = new Files();

                                $userPhoto->related_id = $post->id;
                                $userPhoto->file = $this->path . $gallitem;
                                $userPhoto->main = 0;
                                $userPhoto->type = 0;
                                $userPhoto->related_class = Posts::class;

                                $userPhoto->save();

                            }

                        }

                    }

                }

                $i++;

            }

            exit();

            if ($i > 100) break;

        }


    }

    public function actionPhone()
    {

        $price = array(2000, 3000, 4000, 5000);

        $stream = \fopen(Yii::getAlias('@app/files/import_phone_17_02_2023.csv'), 'r');

        $csv = Reader::createFromStream($stream);
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);

        $stmt = (new Statement());

        $records = $stmt->process($csv);

        $resultData = array();

        foreach ($records as $value) {
            if ($value['phone']) $resultData[$value['city']][] = $value['phone'];
        }

        foreach ($resultData as $key => $item) {

            $cityInfo = City::find()->where(['city' => $key])->one();

            if ($cityInfo) {

                $posts = Posts::find()
                    ->where(['city_id' => $cityInfo['id']])
                    ->andWhere(['phone' => ''])
                    ->all();

                foreach ($posts as $post) {
                    $post->phone = preg_replace('/[^0-9]/', '', $item[array_rand($item)]);
                    $post->save();
                }

            }

        }

    }

    public function actionCom()
    {
        $stream = \fopen(Yii::getAlias('@app/files/comments_true_region_19_01_2022.csv'), 'r');

        $csv = Reader::createFromStream($stream);
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);

        $stmt = (new Statement());

        $records = $stmt->process($csv);

        $comments = [];
        $authors = [];

        foreach ($records as $value) {

            $comments[] = $value['text'];
            $authors[] = $value['author'];

        }

        if ($posts = Posts::find()->where(['<>', 'city_id', 1])->with('service')->all()) {

            foreach ($posts as $post) {

                $review = new Review();

                $review->post_id = $post->id;
                $review->name = $authors[\array_rand($authors)];
                $review->text = $comments[\array_rand($comments)];
                $review->photo_marc = \rand(3, 5);;
                $review->clean = \rand(3, 5);
                $review->is_moderate = 1;
                $review->total_marc = \rand(3, 5);;
                $review->created_at = \rand(1621412504, 1606400623);
                Yii::$app->cache->delete('review_' . $post->id);
                Yii::$app->cache->delete('review_count_' . $post->id);

                if ($review->save()) {

                    if ($post->service) foreach ($post->service as $serviceItem) {

                        $serviceReview = new ServiceReviews();

                        $serviceReview->post_id = $post->id;
                        $serviceReview->service_id = $serviceItem->id;
                        $serviceReview->marc = \rand(3, 5);

                        $serviceReview->save();

                    }

                }

            }

        }

    }

    public function actionAdvert()
    {
        $stream = \fopen(Yii::getAlias('@app/files/advert_10_09_2021.csv'), 'r');

        $csv = Reader::createFromStream($stream);
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);

        //build a statement
        $stmt = (new Statement());

        $records = $stmt->process($csv);

        foreach ($records as $record) {

            $avert = new Advert();

            $avert->title = \strstr($record['text'], '<br>', true);
            $avert->text = \str_replace('<br>', '. ', $record['text']);
            $avert->type = Advert::PUBLIC_TYPE;
            $avert->status = Advert::STATUS_CHECK;

            $avert->save();

        }
    }

    public function actionLink()
    {
        $linkItems = $this->getCsvItems(Yii::getAlias('@app/files/fast_links_23_07_2021.csv'));

        $url = \array_unique(ArrayHelper::getColumn($linkItems, 'page'));

        foreach ($url as $item) {

            $i = 0;

            \shuffle($linkItems);

            foreach ($linkItems as $linkItem) {

                if ($i > 2) break;

                if ($item != $linkItem['page']) {

                    $link = new Link();

                    $link->city_id = 1;

                    $link->url = $item;

                    $link->link = $linkItem['page'];

                    $link->text = $linkItem['key'];

                    $link->save();

                    $i++;

                }

            }

        }

    }

    private function getCsvItems($fileName)
    {

        $stream = \fopen($fileName, 'r');

        $csv = Reader::createFromStream($stream);
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);

        //build a statement
        $stmt = (new Statement());

        $records = $stmt->process($csv);

        $result = array();

        foreach ($records as $record) {

            $result[] = $record;

        }

        return $result;

    }

    public function actionAddCheck()
    {
        $posts = Posts::find()->all();

        foreach ($posts as $post) {

            if (\rand(0, 3) == 3) {

                $post->check_photo_status = 1;

                $post->save();

            }

        }
    }

    public function actionAddReview()
    {
        $stream = \fopen(Yii::getAlias('@app/files/review.csv'), 'r');

        $csv = Reader::createFromStream($stream);
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);

        //build a statement
        $stmt = (new Statement());

        $records = $stmt->process($csv);

        foreach ($records as $record) {

            $post = Posts::find()->where(['name' => $record['name']])->with('service')->asArray()->andWhere(['like', 'phone', $record['price']])->one();

            $data = \explode('#@', $record['age']);

            foreach ($data as $item) {

                $reviewData = \explode('$@', $item);

                if (isset($reviewData[1]) and $reviewData[1] and (int)$reviewData[0] > 0 and $post) {

                    $mark = 2 * ((int)$reviewData[0]);

                    if (!$user = User::find()->where(['username' => $reviewData[1]])->asArray()->one()) {

                        $user = new User();

                        $user->username = $reviewData[1];
                        $user->password_hash = Yii::$app->security->generateRandomString(60);
                        $user->auth_key = Yii::$app->security->generateRandomString();
                        $user->email = $post['id'] . 'admin@mail.com';
                        $user->status = 10;
                        $user->created_at = $time = \time();
                        $user->updated_at = $time;
                        $user->verification_token = Yii::$app->security->generateRandomString(43);

                        $user->save();

                    }

                    $review = new Review();

                    $review->post_id = $post['id'];
                    $review->text = $reviewData[2];
                    $review->photo_marc = ($mark - \rand(-2, 0)) ?? $mark;
                    $review->clean = ($mark - \rand(-2, 0)) ?? $mark;;
                    $review->author = $user['id'];
                    $review->total_marc = $mark;
                    $review->is_happy = \rand(0, 1);
                    $review->created_at = $post['created_at'] + (\rand(0, 3600 * 24 * 14));

                    $review->save();

                    if ($post['service']) {

                        foreach ($post['service'] as $item2) {

                            $serviceReview = new ServiceReviews();

                            $serviceReview->post_id = $post['id'];
                            $serviceReview->service_id = $item2['id'];
                            $serviceReview->marc = \rand(1, 10);

                            $serviceReview->save();

                        }

                    }


                }

            }

        }

    }

    public function actionAddToSites()
    {
        $posts = Posts::find()->where(['updated_at' => 1])->asArray()->all();

        foreach ($posts as $post) {

            $postSite = new PostSites();

            $postSite->post_id = $post['id'];
            $postSite->site_id = 4;
            $postSite->price = $post['price'];
            $postSite->created_at = $post['created_at'];
            $postSite->name_on_site = $post['name'];
            $postSite->age = $post['age'];

            $postSite->save();

        }
    }

    public function actionGal()
    {
        $posts = Posts::find()->where(['updated_at' => 1])->asArray()->all();

        foreach ($posts as $post) {

            if ($files = Files::find()->where(['related_id' => $post['id'], 'related_class' => Posts::class])->all()) {

                foreach ($files as $file) {

                    $file->file = \str_replace('aa2', 'aa3', $file->file);

                    $file->save();

                }

            }

        }
    }

    public function actionVideo()
    {
        $posts = Posts::find()->where(['updated_at' => 1])->all();

        foreach ($posts as $post) {

            if ($post['video']) {

                $post->video = \str_replace('aa2', 'aa3', $post->video);

                $post->save();

            }

        }
    }

    public function actionAddServiceMarc()
    {
        $reviews = Review::find()->with('post')->asArray()->all();

        foreach ($reviews as $review) {

            if ($review['post']['service']) {

                foreach ($review['post']['service'] as $item) {

                    $serviceReview = new ServiceReviews();

                    $serviceReview->post_id = $review['post']['id'];
                    $serviceReview->service_id = $item['id'];
                    $serviceReview->marc = \rand(1, 10);
                    $serviceReview->save();

                }

            }


        }

    }

    public function actionDrop()
    {
        $posts = Posts::find()->where(['updated_at' => 2])->all();

        foreach ($posts as $post) {

            UserMetro::deleteAll(['post_id' => $post->id]);
            UserRayon::deleteAll(['post_id' => $post->id]);
            UserHairColor::deleteAll(['post_id' => $post->id]);
            UserIntimHair::deleteAll(['post_id' => $post->id]);
            UserNational::deleteAll(['post_id' => $post->id]);
            UserOsobenosti::deleteAll(['post_id' => $post->id]);
            UserPlace::deleteAll(['post_id' => $post->id]);
            UserService::deleteAll(['post_id' => $post->id]);
            Files::deleteAll(['related_id' => $post->id, 'related_class' => Posts::class]);

            $post->delete();

        }
    }

    public function actionDns()
    {

        $host = '4-dosug.com';

        $ip = '	185.197.160.135';

        $cityList = array('abakan', 'abinsk', 'achinsk', 'achit', 'admin', 'ahtubinsk', 'akademgorodok', 'aldan', 'aleksandrov', 'aleksin', 'almetevsk', 'alyshta', 'amursk', 'amurzet', 'anadyir', 'anapa', 'angarsk', 'aniva', 'anopino', 'anzhero-sudzhensk', 'apatityi', 'apsheronsk', 'aramil', 'arhangelsk', 'armavir', 'armyansk', 'arsenev', 'artyom', 'arzamas', 'asbest', 'ashitkovo', 'astana', 'astrahan', 'atkarsk', 'aznakaevo', 'azov', 'balakovo', 'balashixa', 'balaxna', 'balesino', 'barabash', 'barnaul', 'bataisk', 'belaya-kalitva', 'belebei', 'belgorod', 'belogorsk', 'belokiryxa', 'beloomyt', 'belorechensk', 'beloreck', 'belovo', 'beloyarskiy', 'berdsk', 'berezniki', 'beryozovskiy', 'beslan', 'birobidzhan2', 'birobidzhan', 'biysk', 'blagodarnyiy', 'blagoveschensk', 'bobruysk', 'bodaybo', 'bogoroditsk', 'bogorodsk', 'boguchar', 'bolshoy-kamen', 'bor', 'borisoglebsk', 'borovichi', 'borovsk', 'borzya', 'bratsk', 'bronnitsyi', 'bryansk', 'budyonnovsk', 'buzuluk', 'bygylma', 'celina', 'chapaevsk', 'chat', 'chebarkul', 'cheboksary', 'chehov', 'chelyabinsk', 'cheremhovo', 'cherepovec', 'cherkessk', 'chernogolovka', 'chernogorsk', 'chernomorskoe', 'chernuska', 'chernyahovsk', 'chita', 'chusovoi', 'dalnegorsk', 'dalnerechensk', 'danilov', 'derbent', 'desnogorsk', 'dimitrovgrad2', 'dimitrovgrad', 'dinskaya', 'dmitrov', 'dobryanka', 'dolgoprudnyiy', 'domodedovo', 'donetsk', 'donskoy', 'dyatkovo', 'dybna', 'dzerzhinsk', 'dzerzhinskiy', 'dzhankoy', 'dzhubga', 'efremov', 'egorevsk', 'ekaterinburg', 'elabyga', 'elec', 'electrostal', 'electrougli', 'elisovo', 'elnya', 'engels', 'essentuki', 'evpatoriya', 'eysk', 'feodosiya', 'fokino', 'fryazevo', 'fryazino', 'furmanov', 'gagarin', 'gatchina', 'gelendzhik', 'georgievsk', 'glasov', 'gomel', 'gorbatov', 'gorki-leninskie', 'gorno-altaisk', 'goroxovec', 'goryachiy-klyuch', 'groznyiy', 'grysi', 'gulkevich', 'gus-hrustalnyiy', 'habarovsk', 'hantimansiysk', 'himki', 'horol', 'hotkovo', 'igrim', 'ilskiy', 'im', 'inza', 'irbit', 'irkutsk', 'ishim', 'iskitim', 'istra', 'ivanovo1', 'ivanovo', 'ivanteevka', 'izhevsk', 'izobilnyiy', 'joshkar-ola', 'kachkanar', 'kalach-na-donu', 'kaliningrad', 'kalininsk', 'kaluga', 'kalyazin', 'kamensk-shahtinskiy', 'kamensk-uralskiy', 'kamyishin', 'kanash', 'kanevskaya', 'kansk', 'karabash', 'karachaevsk', 'kargat', 'kartali', 'kashira', 'kasimov', 'kazan', 'kemerovo', 'kerch2', 'kerch', 'kineshma', 'kingisepp', 'kirensk', 'kirgach', 'kirov1', 'kirov', 'kirovo-chepetsk', 'kirovsk', 'kiselyovsk', 'kislovodsk', 'kizil', 'kizlyar', 'klin', 'klintsi', 'kogalim', 'kokoshkino', 'kolchugino2', 'kolchugino', 'kolomna', 'kolpino', 'komsomolsk-na-amure', 'konakovo', 'kondopoga', 'kondrovo', 'kopeysk', 'korablino', 'korenovsk', 'korolyov', 'korsakov2', 'korsakov', 'kostroma', 'kotelniki', 'kotlas', 'kovrov', 'krasniy-sulin', 'krasnoarmeysk', 'krasnodar', 'krasnoe-selo', 'krasnogorsk', 'krasnogvardeysk', 'krasnokamensk', 'krasnoperekopsk', 'krasnoturinsk', 'krasnoufimsk', 'krasnoyarsk', 'krichev', 'krimsk', 'kropotkin', 'kstovo', 'kubinka', 'kulebaki', 'kuloy', 'kumertau', 'kungur', 'kurgan', 'kurilsk', 'kursk', 'kushchevskaya', 'kuznetsk', 'labinsk', 'labitnangi', 'leningradskaya', 'leninogorsk', 'leninsk-kuznetskiy', 'lensk', 'lermontov', 'lesnoy', 'lesosibirsk', 'likino-dulyovo', 'lipetsk', 'liski', 'lisva', 'litkarino', 'lobachev', 'lobnya', 'lodeynoepole', 'loknya', 'losino-petrovskiy', 'luberci', 'luga', 'luhovitsi', 'luza', 'lyubertsi', 'magadan', 'magnitogorsk', 'mahachkala', 'makarov', 'maloyaroslavets', 'mama', 'maykop', 'mayskiy', 'megdurechensk', 'megion', 'meleuz', 'miass', 'mihaylovka', 'millerovo', 'mineralnie-vodi', 'minusinsk', 'mirniy', 'mitishchi', 'mogga', 'mogilev', 'mogocha', 'monchegorsk', 'morozovsk', 'morshansk', 'moskovskiy', 'mozdok', 'msk', 'mtsensk', 'muravlenko', 'murmansk', 'naberezhnye-chelny', 'nadim', 'nahodka', 'nalchik', 'narofominsk', 'neftecamsk1', 'neftecamsk', 'nefteugansk', 'nekrasovskoe', 'nerungri', 'nevinomssk', 'nijegorodskaya', 'nijneudinsk', 'nijnikamsk', 'nikolaevsknaamure1', 'nikolaevsknaamure', 'nizhnevartovsk', 'nizhniy-novgorod', 'nizhniy-tagil2', 'nizhniy-tagil', 'noginsk', 'nogliki', 'norilsk', 'novachara', 'noviyoskol', 'noviyurengoy', 'novoaleksandrovsk', 'novocherkassk', 'novodvinsk', 'novokubansk', 'novokuybisjevsk', 'novokuzneck', 'novokuznetsk', 'novomosskovsk', 'novorossiysk', 'novosibirsk', 'novotitarovskaya', 'novotroick', 'novouralsk', 'novouzenzk2', 'novouzenzk', 'novurengoy', 'noyabrsk', 'nurlat', 'nyagan', 'obninsk', 'odincovo', 'oha', 'oktyabrskiy', 'olenegorsk', 'omsk', 'opochka', 'orehovozuevo', 'orel1', 'orel', 'orenburg', 'orsk', 'ozersk', 'ozery', 'palasovka', 'pangodi', 'pavlofedorovka', 'pavlovo', 'pavlovsk', 'pavlovskiy', 'pavlovskiyposad', 'pechora', 'penza', 'perevoz', 'perm', 'pervomayskoe', 'pervouralsk', 'pestovo', 'petrodvorec', 'petropavlovskkamchatskiy', 'petrovskzabaykalskiy', 'petrozavodsk', 'pikalevo', 'pitkyantra', 'pityah', 'podolsk', 'pokrov', 'polevskoy', 'polisaevo', 'polyarniezori', 'poronaysk', 'prohladniy', 'prokopievsk', 'proletarsk', 'protvino', 'pskov2', 'pskov', 'pstrogojsk', 'pugachev', 'pushkino', 'pyatigorsk', 'radujniy', 'raichinsk', 'ramenskoe', 'redkino', 'reftinskiy', 'reutov', 'revda', 'ribinsk', 'ribnoe', 'rjev', 'roschino', 'rossosh', 'rostov', 'rostov-na-dony', 'rostovvelikiy', 'rtischevo1', 'rtischevo', 'rubzovo', 'rusa', 'ryazan', 'sajanogorsk', 'salavat', 'salehard', 'salsk', 'samara1', 'samara', 'sankt-piterburg', 'saraktash', 'saransk', 'saratov', 'sarov', 'satka', 'segezha', 'sengilej', 'sergach', 'sergiev-posad', 'serpuhov', 'sertolovo', 'sevastopol', 'severobajkalsk', 'severodvinsk', 'severomorsk', 'seversk', 'severskaja', 'shadrinsk', 'shahti', 'sharya', 'shatura', 'shekino', 'shelehov', 'shelkovo', 'shimanovsk', 'shushenskoe', 'sibaj', 'simferopol', 'slavjansk-na-kubani', 'smolensk', 'snezhinsk', 'snezhnogorsk', 'sochi', 'solikamsk', 'solnechnodolsk', 'solnechnogorsk', 'sorochinsk', 'sortavala', 'sosenskij', 'sosnovyj-bor', 'sovetsk', 'sovetskaja-gavan', 'sovetskij', 'spassk-rjazanskij', 'starica', 'staryj-oskol', 'stavropol', 'sterlitamak', 'strezhevoj', 'strunino', 'stupino1', 'stupino', 'sudak', 'suhinichi', 'suhoj-log', 'surgut', 'surovikino', 'svirsk', 'svobodnyj', 'syktyvkar1', 'syktyvkar', 'syzran', 'taganrog', 'talica', 'talnah', 'taman', 'tambov', 'tashtagol', 'tayshet', 'teikovo', 'tihoretsk', 'tihvin', 'tinda', 'tobolsk', 'tolyati', 'tolyatti2', 'tolyatti', 'tomsk', 'troick', 'tryohgorniy', 'tuapce', 'tula', 'tumen', 'tutaev', 'tver', 'ubileyniy', 'ufa', 'uhta', 'ujnosahalinsk', 'ujnouralsk1', 'ujnouralsk', 'ujur', 'ulan-ude', 'ulyanovsk', 'unecha', 'uray', 'uren', 'urga', 'usinsk', 'usolesibirskoe', 'ussuriyks', 'ustilimsk', 'ustkut', 'ustlabinsk', 'uva', 'uvarovo', 'uzlovaya', 'valuyki', 'vanev', 'vanino', 'vatytinki', 'velikie-luki', 'velikiy-novgorod', 'velsk', 'verhniy-ufaley', 'veshenskaya', 'vidnoe', 'vilyuchinsk', 'vitebsk', 'vladikavkaz', 'vladimir', 'vladivostok', 'volgodansk', 'volgograd', 'vologda', 'volokolamsk', 'volsk', 'volzhsk', 'volzhskiy', 'vorkuta', 'voronezh', 'voskresensk', 'votkinsk', 'vyasniki', 'vyazma', 'vyiborg', 'vyichegodskiy', 'vyishniy-volochyok', 'yakutsk2', 'yakutsk', 'yalta', 'yarcevo', 'yaroslavl', 'yarovoe', 'zabaykalsk', 'zapolyarnyiy', 'zaraysk', 'zarechnyiy', 'zavodoukovsk', 'zelenodolsk', 'zelenogorsk', 'zelenograd', 'zelenokumsk', 'zernograd', 'zeya', 'zheleznodorozhnyiy', 'zheleznogorsk', 'zheleznogorsk-ilimskiy', 'zheleznovodsk', 'zhigulyovsk', 'zhukovka', 'zhukovskiy', 'zima', 'zlatoust', 'zlyinka', 'zvenigorod', 'zverevo');

        foreach ($cityList as $cityItem) {

            $city = $cityItem;

            $content = array(
                'type' => "A",
                'name' => $city,
                'content' => $ip,
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.cloudflare.com/client/v4/zones/5117157d67a9cdbd9992cbd32fe318b9/dns_records");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($content));  //Post Fields
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $headers = [
                'X-Auth-Email: ' . 'aprutic@gmail.com',
                'X-Auth-Key: ' . 'f716ab864dd1d40dab325c43b64e185bfd517',
                'Content-Type: application/json',
            ];

            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $server_output = curl_exec($ch);

            $object = json_decode($server_output);

            if (!isset($object->result->id)) continue;

            $zapid = $object->result->id;

            curl_close($ch);

            // пытаемся поставить галочку на облаке
            $zoneindetif = "https://api.cloudflare.com/client/v4/zones/5117157d67a9cdbd9992cbd32fe318b9/dns_records/$zapid";


            $content = array(
                'type' => "A",
                'name' => $city,
                'content' => $ip,
                'proxied' => true,
            );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $zoneindetif);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($content));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $server_output = curl_exec($ch);

            echo $city . PHP_EOL;

        }

    }

    public function actionWebmaster()
    {
        $access_token = 'y0_AgAAAABNB5owAAOcKgAAAADj-ZoaFQ2AImXXTSSKrpFrlxvoUYxeHN8';
        $host = 'intim-boxx.com';

        $cityList = City::find()->all();


        foreach ($cityList as $url) {

            $city = $url;

            if ($city) {

                $opts = array(
                    'http' => array(
                        'method' => "GET",
                        'header' => "Accept-language: en\r\n" .
                            "Cookie: foo=bar\r\n" .
                            'Authorization: OAuth ' . $access_token,
                    )
                );

                $context = stream_context_create($opts);

                $user_id = file_get_contents("https://api.webmaster.yandex.net/v3/user/", false, $context);
                $user_id = json_decode($user_id);
                $user_id = $user_id->user_id;


                $content = '
                
                <Data>
                    <host_url>https://' . $city['url'] . '.' . $host . '</host_url>
                </Data>
                
                ';


                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://api.webmaster.yandex.net/v4/user/{$user_id}/hosts/");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $content);  //Post Fields
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $headers = [
                    'Content-type: application/xml',
                    'Authorization: OAuth ' . $access_token
                ];

                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $server_output = curl_exec($ch);

                curl_close($ch);

                $result = json_decode($server_output);


                $content = '';

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://api.webmaster.yandex.net/v3/user/{$user_id}/hosts/" . urlencode($result->host_id) . "/verification/?verification_type=HTML_FILE");
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $content);  //Post Fields
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $server_output = curl_exec($ch);

                curl_close($ch);

                $server_output = json_decode($server_output);

                //$meta2 = $server_output->verification_uin;

                //$meta_model = new Webmaster();

                //$meta_model->city_id = $city['id'];
                //$meta_model->tag = $meta2;

                //$meta_model->save();

                //Yii::$app->cache->flush();

                dd($city);

            }

        }
    }

    public function actionAddService()
    {
        $newService = array('Cекс по телефону', 'Виртуальный секс', 'Игрушки', 'Клизма', 'Легкое подчинение',
            'Лесби откровенное', 'Порка', 'Профессиональный массаж', 'Расслабляющий массаж', 'Секс групповой', 'Секс лесбийский',
            'Стриптиз профи', 'Трамплинг', 'Услуги семейной паре', 'Фетиш', 'Фингеринг', 'Фото/видео съемка',
            'Целуюсь');

        $posts = Posts::find()->asArray()->all();

        foreach ($newService as $item) {

            $translit = new Translit();

            if ($service = Service::find()->where(['value' => $item])->asArray()->one()) {

                foreach ($posts as $post) {

                    if (\rand(0, 2) == 1) {

                        $userService = new UserService();

                        $userService->service_id = $service['id'];
                        $userService->post_id = $post['id'];
                        $userService->city_id = $post['city_id'];

                        $userService->save();

                    }

                }

            }

        }

    }

    public function actionAddServiceComments()
    {
        $stream = \fopen(Yii::getAlias('@app/files/comments_for_service.csv'), 'r');

        $csv = Reader::createFromStream($stream);
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);
        $translit = new Translit();
        //build a statement
        $stmt = (new Statement());

        $records = $stmt->process($csv);

        $values = array();

        foreach ($records as $record) {

            $values[] = $record;

        }
        $arr = array();
        foreach ($values as $value) {

            foreach ($values as $item) {

                if ($value['key'] == $item['key']) {

                    if (isset($arr[$item['key']]) and \is_array($arr[$item['key']])) {

                        if (!\in_array($value['value'], $arr[$item['key']])) $arr[$item['key']][] = $value['value'];

                    } else $arr[$item['key']][] = $value['value'];


                }

            }

        }

        foreach ($arr as $key => $value) {

            if ($service = Service::find()->where(['value' => $key])->with('posts')->asArray()->one()) {

                foreach ($service['posts'] as $item) {

                    if (\rand(0, 1) == 1) {

                        $serviceDesc = new ServiceDesc();
                        $serviceDesc->post_id = $item['post_id'];
                        $serviceDesc->service_id = $item['service_id'];

                        $serviceDesc->text = $value[\array_rand($value)];

                        $serviceDesc->save();

                    }

                }

            }

        }

    }

    public function actionAddRandomReview()
    {
        $posts = Posts::find()->asArray()->all();

        foreach ($posts as $post) {

            if (!Review::find()->where(['post_id' => $post['id']])->count()) {

                $review = new Review();

                $review->post_id = $post['id'];
                $review->photo_marc = \rand(4, 10);
                $review->total_marc = \rand(5, 10);
                $review->clean = \rand(2, 10);
                $review->is_happy = \rand(0, 1);

                $review->save();

                $service = UserService::find()->where(['post_id' => $post['id']])->asArray()->all();

                foreach ($service as $serviceItem) {

                    $servRev = new ServiceReviews();

                    $servRev->post_id = $post['id'];
                    $servRev->service_id = $serviceItem['service_id'];
                    $servRev->marc = \rand(3, 10);

                    $servRev->save();

                }


            }

        }
    }


}