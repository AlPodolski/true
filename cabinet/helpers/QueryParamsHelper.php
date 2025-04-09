<?php


namespace cabinet\helpers;


use common\models\City;
use common\models\Pol;
use common\models\Rayon;
use cabinet\components\helpers\GetOrderHelper;
use cabinet\models\Files;
use cabinet\models\FilterParams;
use cabinet\models\Metro;
use cabinet\modules\user\models\Posts;
use cabinet\modules\user\models\Review;
use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class QueryParamsHelper
{

    public static function getPosts($params, $city, $limit, $offset): array
    {
        $posts = Posts::find()
            ->where(['city_id' => $city])
            ->with('metro', 'avatar', 'place', 'strizhka', 'service', 'nacionalnost')
            ->limit($limit)
            ->orderBy((new GetOrderHelper())->get())
            ->offset($offset);

        $params = explode('/', $params);

        foreach ($params as $param) {

            if (\strpos($param, 'metro-') !== false) {

                $cityWithMetro = [161, 1];

                $data = '';
                $data = str_replace('metro-', '', $param);
                $metro = Metro::getByUrl($data, $city);

                if (!in_array($city, $cityWithMetro) ) throw new NotFoundHttpException();
                if (!$metro ) throw new NotFoundHttpException();

                $tempSql = ' id in (select `post_id` from `user_metro` where `metro_id` in ';
                $tempSql .= ' (select `id` from metro where url = :metro and city_id = :city_id))';

                $posts = $posts->andWhere($tempSql, [':metro' => $data, ':city_id' => $city]);

            }

            if (\strpos($param, 'rayon-') !== false) {

                $data = str_replace('rayon-', '', $param);

                $rayon = Rayon::getByUrl($data, $city);
                if (!$rayon) throw new NotFoundHttpException();

                $tempSql = ' rayon_id in (select `id` from rayon where url = :rayon and city_id = :city_id) ';

                $posts = $posts->andWhere($tempSql, [':rayon' => $data, ':city_id' => $city]);

            }

            if (\strpos($param, 'usluga-') !== false) {

                $data = str_replace('usluga-', '', $param);

                $tempSql = ' id in (select `post_id` from `user_service` where `service_id` in ';
                $tempSql .= ' (select `id` from service where url = :service and city_id = :city_id))';

                $posts = $posts->andWhere($tempSql, [':service' => $data, ':city_id' => $city]);

            }

            if (\strpos($param, 'cvet-volos-') !== false) {

                $data = str_replace('cvet-volos-', '', $param);

                $tempSql = ' hair_color_id in (select `id` from hair_color where url = :hair_color)';

                $posts = $posts->andWhere($tempSql, [':hair_color' => $data]);

            }

            if (\strpos($param, 'intimnaya-strizhka-') !== false) {

                $data = str_replace('intimnaya-strizhka-', '', $param);

                $tempSql = ' intim_hair_id in (select `id` from intim_hair where url = :intim_hair) ';

                $posts = $posts->andWhere($tempSql, [':intim_hair' => $data]);

            }

            if (\strpos($param, 'nacionalnost-') !== false) {

                $data = '';
                $data = str_replace('nacionalnost-', '', $param);

                $tempSql = ' national_id in (select `id` from national where url = :national) ';

                $posts = $posts->andWhere($tempSql, [':national' => $data]);

            }

            if (\strpos($param, 'mesto-') !== false) {

                $data = str_replace('mesto-', '', $param);

                $tempSql = ' id in (select `post_id` from `user_place` where `place_id` in ';
                $tempSql .= ' (select `id` from place where url = :place))';

                $posts = $posts->andWhere($tempSql, [':place' => $data]);

            }

            if (\strpos($param, 'vremya-') !== false) {

                $data = str_replace('vremya-', '', $param);

                $tempSql = ' id in (select `post_id` from `user_time` where `param_id` in ';
                $tempSql .= ' (select `id` from time where url = :time))';

                $posts = $posts->andWhere($tempSql, [':time' => $data]);

            }

            if (\strpos($param, 'pol-') !== false) {

                $data = str_replace('pol-', '', $param);

                $pol = Pol::findOne(['url' => $data]);

                Yii::$app->params['breadcrumbs'][] = array(
                    'label' => $pol->value,
                );

                $posts = $posts->andWhere(['pol_id' => $pol->id]);

            }

            if (\strpos($param, 'ves-') !== false) {

                $data = str_replace('ves-', '', $param);

                if ($data == 'tolstye') {
                    Yii::$app->params['breadcrumbs'][] = array(
                        'label' => 'Толстые',
                        'url' => Yii::$app->params['breadcrumbs'] ? 'ves-tolstye' : '/ves-tolstye',
                    );
                    $price_params[] = ['>', 'ves', 80];
                }

                if ($data == 'hudye') {
                    Yii::$app->params['breadcrumbs'][] = array(
                        'label' => 'Худые',
                        'url' => Yii::$app->params['breadcrumbs'] ? 'ves-hudye' : '/ves-hudye',
                    );
                    $price_params[] = ['<', 'ves', 60];

                }

                if ($price_params) foreach ($price_params as $price_param) {
                    $posts = $posts->andWhere($price_param);
                };

            }

            if (\strpos($param, 'rost-') !== false) {

                $data = str_replace('rost-', '', $param);

                $price_params = array();

                if ($data == 'visokii') {
                    Yii::$app->params['breadcrumbs'][] = array(
                        'label' => 'Высокие',
                        'url' => Yii::$app->params['breadcrumbs'] ? 'rost-visokii' : '/rost-visokii',
                    );
                    $price_params[] = ['>', 'rost', 179];
                }

                if ($data == 'srednii') {
                    Yii::$app->params['breadcrumbs'][] = array(
                        'label' => 'Среднего роста',
                        'url' => Yii::$app->params['breadcrumbs'] ? 'rost-srednii' : '/rost-srednii',
                    );
                    $price_params[] = ['>=', 'rost', 158];
                    $price_params[] = ['<', 'rost', 180];
                }

                if ($data == 'nizkii') {
                    Yii::$app->params['breadcrumbs'][] = array(
                        'label' => 'Низкие',
                        'url' => Yii::$app->params['breadcrumbs'] ? 'rost-nizkii' : '/rost-nizkii',
                    );

                    $price_params[] = ['<', 'ves', 60];

                }

                if ($price_params) foreach ($price_params as $price_param) {
                    $posts = $posts->andWhere($price_param);
                };

            }

            if (\strpos($param, 'cena-') !== false) {

                $data = str_replace('cena-', '', $param);

                $price_params = array();

                if ($data == 'do-1500') {
                    Yii::$app->params['breadcrumbs'][] = array(
                        'label' => 'цена до 1500',
                    );
                    $price_params[] = ['<', 'price', 1501];
                }

                if ($data == 'do-3000') {
                    Yii::$app->params['breadcrumbs'][] = array(
                        'label' => 'цена до 3000',
                        'url' => Yii::$app->params['breadcrumbs'] ? 'cena-do-3000' : '/cena-do-3000',
                    );
                    $price_params[] = ['<', 'price', 3001];
                }

                if ($data == 'ot-1500-do-2000') {
                    $price_params[] = ['>=', 'price', 1500];
                    $price_params[] = ['<=', 'price', 1999];
                    Yii::$app->params['breadcrumbs'][] = array(
                        'label' => 'цена от 1500 до 2000',
                    );
                }
                if ($data == 'ot-2000-do-3000') {
                    $price_params[] = ['>=', 'price', 2000];
                    $price_params[] = ['<=', 'price', 2999];
                    Yii::$app->params['breadcrumbs'][] = array(
                        'label' => 'цена от 2000 до 3000',
                    );
                }
                if ($data == 'ot-3000-do-6000') {
                    $price_params[] = ['>=', 'price', 3000];
                    $price_params[] = ['<=', 'price', 6000];
                    Yii::$app->params['breadcrumbs'][] = array(
                        'label' => 'цена от 3000 до 6000',
                    );
                }

                if ($data == 'ot-6000') {
                    Yii::$app->params['breadcrumbs'][] = array(
                        'label' => 'цена от 6000',
                    );
                    $price_params[] = ['>=', 'price', 6001];
                }

                if ($price_params) foreach ($price_params as $price_param) {
                    $posts = $posts->andWhere($price_param);
                };

            }

            if (\strpos($param, 'vozrast-') !== false) {

                $data = str_replace('vozrast-', '', $param);

                $ageRange = \explode('-', $data);

                if (\is_array($ageRange) and (\count($ageRange) == 2)) {

                    Yii::$app->params['breadcrumbs'][] = array(
                        'label' => 'возраст от ' . $ageRange[0] . ' до ' . $ageRange[1],
                        'url' => Yii::$app->params['breadcrumbs'] ? $param : '/' . $param,
                    );

                    $posts = $posts
                        ->andWhere(['>', 'age', $ageRange[0]])
                        ->andWhere(['<', 'age', $ageRange[1]]);

                }

            }

            if ($param == 'deshevye-prostitutki') {

                $posts = $posts->andWhere(['<', 'price', 3001]);

                Yii::$app->params['breadcrumbs'][] = array(
                    'label' => 'Дешевые проститутки',
                );

            }

            if ($param == 'elitnye-prostitutki') {

                $posts = $posts->andWhere(['>', 'price', 4999]);

                Yii::$app->params['breadcrumbs'][] = array(
                    'label' => 'Дешевые проститутки',
                );

            }

            if ($param == 'proverennye') {

                $posts = $posts->andWhere(['check_photo_status' => 1]);

                Yii::$app->params['breadcrumbs'][] = array(
                    'label' => 'проверенные',
                );

            }

            if ($param == 'prostitutki-s-otzyvami') {

                Yii::$app->params['breadcrumbs'][] = array(
                    'label' => 'проститутки с отзывами',
                );

                $tempSql = ' id in (SELECT DISTINCT(`post_id`)  FROM `review` where `is_moderate` = :is_moderate) ';

                $posts = $posts->andWhere($tempSql, [':is_moderate' => Review::MODARATE]);

            }

            if ($param == 'prostitutki-s-selfi') {

                Yii::$app->params['breadcrumbs'][] = array(
                    'label' => 'анкеты с селфи',
                );

                $tempSql = ' id in (SELECT DISTINCT(`related_id`) FROM `files` where `type` = :type) ';

                $posts = $posts->andWhere($tempSql, [':type' => Files::SELPHY_TYPE]);

            }

            if ($param == 'video') {

                Yii::$app->params['breadcrumbs'][] = array(
                    'label' => 'анкеты с видео',
                );

                $posts = $posts->andWhere(['<>', 'video', '']);

            }

            if ($param == 'salon') {

                Yii::$app->params['breadcrumbs'][] = array(
                    'label' => 'Интим салоны',
                );

                $posts = $posts->andWhere(['category' => Posts::SALON_CATEGORY]);

            }

            if ($param == 'novie') {

                Yii::$app->params['breadcrumbs'][] = array(
                    'label' => 'Новые анкеты',
                );

                $posts = $posts->orderBy(['created_at' => SORT_DESC]);

            }

        }

        $posts = $posts->all();

        return $posts;
    }

}