<?php


namespace frontend\helpers;


use common\models\City;
use common\models\Pol;
use frontend\models\Files;
use frontend\models\FilterParams;
use frontend\modules\user\models\Posts;
use frontend\modules\user\models\Review;
use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;

class QueryParamsHelper
{
    public static function getParams($params, $city)
    {

        $city = City::getCity($city);

        $params = explode('/', $params);

        $filter_params = FilterParams::find()->asArray()->cache(3600)->all();

        $ids = array();

        $query_params = array();

        $bread_crumbs_params = array();

        $stem = 0;

        $polSearch = false;

        //Перебираем параметры
        foreach ($params as $value) {

            foreach ($filter_params as $filter_param) {

                $result_id_array = array();

                if (strpos($value, $filter_param['url']) !== false) {

                    $className = $filter_param['class_name'];
                    $classRelationName = $filter_param['relation_class'];

                    $url = self::prepareUrl($filter_param['url'], $value);

                    if ($url and $className and $classRelationName) {

                        if ($className == 'frontend\models\Metro' or $className == 'common\models\Rayon') {

                            $id = $className::find()->where(['url' => $url, 'city_id' => $city['id']])->cache(3600)->asArray()->one();

                        } else {

                            $id = $className::find()->where(['url' => $url])->cache(3600)->asArray()->one();

                        }

                        if (isset($id['value'])) {
                            Yii::$app->params['breadcrumbs'][] = array(
                                'label' => $id['value'],
                                'url' => '/' . $value,
                            );
                        }

                        if ($id and $classRelationName) {

                            if (!empty($ids)) {

                                $relationsIds = ArrayHelper::getColumn($classRelationName::find()
                                    ->where([$filter_param['column_param_name'] => $id['id']])
                                    ->andWhere(['city_id' => $city['id']])
                                    ->asArray()->all(), 'post_id');

                                $ids = array_intersect($ids, $relationsIds);

                            } else {

                                $ids = ArrayHelper::getColumn($classRelationName::find()
                                    ->where([$filter_param['column_param_name'] => $id['id']])
                                    ->andWhere(['city_id' => $city['id']])
                                    ->asArray()->all(), 'post_id');

                            }

                            if (empty($ids)) {
                                $ids[] = [
                                    '0' => 0
                                ];
                            }

                        }

                    }

                }

            }

            if (\strpos($value, 'vozrast-') !== false) {

                $url = str_replace('vozrast-', '', $value);

                $ageRange = \explode('-', $url);

                if (\is_array($ageRange) and (\count($ageRange) == 2)) {

                    Yii::$app->params['breadcrumbs'][] = array(
                        'label' => 'возраст от ' . $ageRange[0] . ' до ' . $ageRange[1],
                        'url' => Yii::$app->params['breadcrumbs'] ? $value : '/' . $value,
                    );

                    $id = Posts::find()
                        ->select('id')
                        ->where(['>', 'age', $ageRange[0]])
                        ->andWhere(['<', 'age', $ageRange[1]])
                        ->andWhere(['city_id' => $city['id']])
                        ->asArray()
                        ->all();

                    $ids = self::intersect_data($id, $ids);

                }

            }

            if (strpos($value, 'cena-') !== false) {

                $url = str_replace('cena-', '', $value);

                $price_params = array();

                if ($url == 'do-1500') {
                    Yii::$app->params['breadcrumbs'][] = array(
                        'label' => 'цена до 1500',
                    );
                    $price_params[] = ['<', 'price', 1501];
                }

                if ($url == 'do-3000') {
                    Yii::$app->params['breadcrumbs'][] = array(
                        'label' => 'цена до 3000',
                        'url' => Yii::$app->params['breadcrumbs'] ? 'cena-do-3000' : '/cena-do-3000',
                    );
                    $price_params[] = ['<', 'price', 3001];
                }

                if ($url == 'ot-1500-do-2000') {
                    $price_params[] = ['>=', 'price', 1500];
                    $price_params[] = ['<=', 'price', 1999];
                    Yii::$app->params['breadcrumbs'][] = array(
                        'label' => 'цена от 1500 до 2000',
                    );
                }
                if ($url == 'ot-2000-do-3000') {
                    $price_params[] = ['>=', 'price', 2000];
                    $price_params[] = ['<=', 'price', 2999];
                    Yii::$app->params['breadcrumbs'][] = array(
                        'label' => 'цена от 2000 до 3000',
                    );
                }
                if ($url == 'ot-3000-do-6000') {
                    $price_params[] = ['>=', 'price', 3000];
                    $price_params[] = ['<=', 'price', 6000];
                    Yii::$app->params['breadcrumbs'][] = array(
                        'label' => 'цена от 3000 до 6000',
                    );
                }

                if ($url == 'ot-6000') {
                    Yii::$app->params['breadcrumbs'][] = array(
                        'label' => 'цена от 6000',
                    );
                    $price_params[] = ['>=', 'price', 6001];
                }

                $id = Posts::find()->andWhere(['city_id' => $city['id']])->select('id');

                foreach ($price_params as $price_param) {
                    $id->andWhere($price_param);
                }

                $id = $id->asArray()->all();

                $ids = self::intersect_data($id, $ids);

            }

            if (strpos($value, 'rost-') !== false) {

                $url = str_replace('rost-', '', $value);

                $price_params = array();

                if ($url == 'visokii') {
                    Yii::$app->params['breadcrumbs'][] = array(
                        'label' => 'Высокие',
                        'url' => Yii::$app->params['breadcrumbs'] ? 'rost-visokii' : '/rost-visokii',
                    );
                    $price_params[] = ['>', 'rost', 179];
                }

                if ($url == 'srednii') {
                    Yii::$app->params['breadcrumbs'][] = array(
                        'label' => 'Среднего роста',
                        'url' => Yii::$app->params['breadcrumbs'] ? 'rost-srednii' : '/rost-srednii',
                    );
                    $price_params[] = ['>=', 'rost', 158];
                    $price_params[] = ['<', 'rost', 180];
                }

                if ($url == 'nizkii') {
                    Yii::$app->params['breadcrumbs'][] = array(
                        'label' => 'Низкие',
                        'url' => Yii::$app->params['breadcrumbs'] ? 'rost-nizkii' : '/rost-nizkii',
                    );
                    $price_params[] = ['<', 'rost', 157];
                }

                $id = Posts::find()->andWhere(['city_id' => $city['id']])->select('id');

                foreach ($price_params as $price_param) {
                    $id->andWhere($price_param);
                }

                $id = $id->asArray()->all();

                $ids = self::intersect_data($id, $ids);

            }

            if (strpos($value, 'ves-') !== false) {

                $url = str_replace('ves-', '', $value);

                $price_params = array();

                if ($url == 'tolstye') {
                    Yii::$app->params['breadcrumbs'][] = array(
                        'label' => 'Толстые',
                        'url' => Yii::$app->params['breadcrumbs'] ? 'ves-tolstye' : '/ves-tolstye',
                    );
                    $price_params[] = ['>', 'ves', 80];
                }

                if ($url == 'hudye') {
                    Yii::$app->params['breadcrumbs'][] = array(
                        'label' => 'Худые',
                        'url' => Yii::$app->params['breadcrumbs'] ? 'ves-hudye' : '/ves-hudye',
                    );
                    $price_params[] = ['<', 'ves', 60];

                }

                $id = Posts::find()->andWhere(['city_id' => $city['id']])->select('id');

                foreach ($price_params as $price_param) {
                    $id->andWhere($price_param);
                }

                $id = $id->asArray()->all();

                $ids = self::intersect_data($id, $ids);

            }

            if ($value == 'proverennye') {

                $id = Posts::find()->select('id')->andWhere(['city_id' => $city['id']])->andWhere(['check_photo_status' => 1])->asArray()->all();

                Yii::$app->params['breadcrumbs'][] = array(
                    'label' => 'проверенные',
                );

                $ids = self::intersect_data($id, $ids);

            }

            if (strpos($value, 'novie') !== false) {

                $id = Posts::find()->select('id')->andWhere(['city_id' => $city['id']])->orderBy(['created_at' => SORT_DESC])->asArray()->all();

                Yii::$app->params['breadcrumbs'][] = array(
                    'label' => 'Новые анкеты',
                );

                $ids = self::intersect_data($id, $ids);

            }

            if (strstr($value, 'salon')) {

                $id = Posts::find()->select('id')->andWhere(['city_id' => $city['id']])
                    ->andWhere(['category' => Posts::SALON_CATEGORY])->asArray()->all();

                Yii::$app->params['breadcrumbs'][] = array(
                    'label' => 'Интим салоны',
                );

                $ids = self::intersect_data($id, $ids);

            }

            if ($value == 'elitnye-prostitutki') {

                $id = Posts::find()->select('id')->andWhere(['city_id' => $city['id']])
                    ->andWhere(['>', 'price', 4999])->asArray()->all();

                Yii::$app->params['breadcrumbs'][] = array(
                    'label' => 'Элитные проститутки',
                );

                $id = ArrayHelper::getColumn($id, 'id');

                if (!empty($ids)) $ids = array_intersect($ids, $id);

                else $ids = $id;

                if (empty($ids)) {
                    $ids[] = [
                        '0' => 0
                    ];
                }

            }

            if ($value == 'deshevye-prostitutki') {

                $id = Posts::find()->select('id')->andWhere(['city_id' => $city['id']])
                    ->andWhere(['<', 'price', 3001])->asArray()->all();

                Yii::$app->params['breadcrumbs'][] = array(
                    'label' => 'Дешевые проститутки',
                );

                $id = ArrayHelper::getColumn($id, 'id');

                if (!empty($ids)) $ids = array_intersect($ids, $id);

                else $ids = $id;

                if (empty($ids)) {
                    $ids[] = [
                        '0' => 0
                    ];
                }

            }

            if (strpos($value, 'pol-') !== false) {

                $polSearch = true;

                $url = str_replace('pol-', '', $value);

                $pol = Pol::findOne(['url' => $url]);

                $id = Posts::find()->select('id')->andWhere(['city_id' => $city['id']])
                    ->andWhere(['pol_id' => $pol['id']])->asArray()->all();

                Yii::$app->params['breadcrumbs'][] = array(
                    'label' => 'Пол ' . $pol['value'],
                );

                $ids = self::intersect_data($id, $ids);

            }

            if ($value == 'video') {

                Yii::$app->params['breadcrumbs'][] = array(
                    'label' => 'анкеты с видео',
                );

                $id = Posts::find()->select('id')->andWhere(['city_id' => $city['id']])->andWhere(['<>', 'video', ''])->asArray()->all();

                $ids = self::intersect_data($id, $ids);

            }

            if ($value == 'prostitutki-s-selfi') {

                Yii::$app->params['breadcrumbs'][] = array(
                    'label' => 'анкеты с селфи',
                );

                $postsIds = Files::find()->where(['type' => Files::SELPHY_TYPE])
                    ->select('related_id')
                    ->asArray()->all();

                $id = Posts::find()->select('id')
                    ->where(['in', 'id', ArrayHelper::getColumn($postsIds, 'related_id')])->asArray()->all();

                $ids = self::intersect_data($id, $ids);

            }

            if ($value == 'prostitutki-s-otzyvami') {

                Yii::$app->params['breadcrumbs'][] = array(
                    'label' => 'проститутки с отзывами',
                );

                $id = Review::find()->select('post_id')
                    ->distinct()
                    ->where(['is_moderate' => Review::MODARATE])
                    ->asArray()
                    ->cache(3600)
                    ->all();

                $resultPostsIds = ArrayHelper::getColumn($id, 'post_id');

                if (!empty($ids)) $ids = array_intersect($ids, $resultPostsIds);

                else $ids = $resultPostsIds;

                if (empty($ids)) {
                    $ids[] = [
                        '0' => 0
                    ];
                }

            }

        }

        if ($ids) {

            Yii::$app->params['result_id'] = $ids;

            $query_params[] = ['in', 'id', $ids];

        }

        if (!$polSearch and $query_params) $query_params[] = ['pol_id' => Pol::WOMAN_POL];

        if (!empty($query_params)) {

            return $query_params;

        }

    }

    public static function getPosts($params, $city, $limit, $offset)
    {

        $postsIds = Yii::$app->cache->get('filter_'.$city.'_'.$params);

        if ($postsIds === false) {

            $postsIds = self::prepare($params, $city);

            // Сохраняем значение $data в кэше. Данные можно получить в следующий раз.
            Yii::$app->cache->set('filter_'.$city.'_'.$params, $postsIds, 300);

        }

        $data = Posts::find()->where(['in', 'id', $postsIds])
            ->select(['id', 'name', 'rost', 'ves', 'age', 'breast',
                'check_photo_status', 'tarif_id', 'price', 'phone', 'video'])
            ->with('avatar', 'metro','gallery', 'tarif')
            ->andWhere(['status' => Posts::POST_ON_PUPLICATION_STATUS])
            ->orderBy(Posts::getOrder())
            ->asArray()
            ->limit($limit);
            if ($offset) $data = $data->offset($offset);
            $data = $data->all();

        return $data;

    }

    public static function prepare($params, $city)
    {
        $posts = Posts::find()->where(['city_id' => $city])
            ->asArray()
            ->select(['id']);

        $params = explode('/', $params);

        foreach ($params as $param) {

            if (\strpos($param, 'metro-') !== false) {

                $data = '';
                $data = str_replace('metro-', '', $param);

                $tempSql = ' id in (select `post_id` from `user_metro` where `metro_id` in ';
                $tempSql .= ' (select `id` from metro where url = :metro and city_id = :city_id))';

                $posts = $posts->andWhere($tempSql, [':metro' => $data, ':city_id' => $city]);

            }

            if (\strpos($param, 'rayon-') !== false) {

                $data = str_replace('rayon-', '', $param);

                $tempSql = ' id in (select `post_id` from `user_rayon` where `rayon_id` in ';
                $tempSql .= ' (select `id` from rayon where url = :rayon and city_id = :city_id))';

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

                $tempSql = ' id in (select `post_id` from `user_hair_color` where `hair_color_id` in ';
                $tempSql .= ' (select `id` from hair_color where url = :hair_color))';

                $posts = $posts->andWhere($tempSql, [':hair_color' => $data]);

            }

            if (\strpos($param, 'intimnaya-strizhka-') !== false) {

                $data = str_replace('intimnaya-strizhka-', '', $param);

                $tempSql = ' id in (select `post_id` from `user_intim_hair` where `color_id` in ';
                $tempSql .= ' (select `id` from intim_hair where url = :intim_hair))';

                $posts = $posts->andWhere($tempSql, [':intim_hair' => $data]);

            }

            if (\strpos($param, 'nacionalnost-') !== false) {

                $data = '';
                $data = str_replace('nacionalnost-', '', $param);

                $tempSql = ' id in (select `post_id` from `user_national` where `national_id` in ';
                $tempSql .= ' (select `id` from national where url = :national))';

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

                $posts = $posts->andWhere($price_params);

            }

            if (\strpos($param, 'rost-') !== false) {

                $data = str_replace('rost-', '', $param);

                $price_params = '';

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
                    $price_params[] = ['<', 'rost', 157];
                }

                if ($price_params) $posts = $posts->andWhere($price_params);

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

                    $posts = Posts::find()
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

    private static function intersect_data($id, $ids)
    {

        if ($id) {

            $result = ArrayHelper::getColumn($id, 'id');

            if (!empty($ids)) {

                $ids = array_intersect($ids, $result);

            } else {

                $ids = $result;

            }

        }

        if (empty($ids)) {
            $ids[] = [
                '0' => 0
            ];
        }

        return $ids;

    }

    public static function prepareUrl($url, $value)
    {

        if ($url == $value) return $url;

        return str_replace($url . '-', '', $value);
    }

}