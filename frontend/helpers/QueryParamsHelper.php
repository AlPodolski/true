<?php


namespace frontend\helpers;


use common\models\City;
use frontend\models\FilterParams;
use frontend\modules\user\models\Posts;
use Yii;
use yii\helpers\ArrayHelper;

class QueryParamsHelper
{
    public static function getParams($params,$city)
    {

        $city = City::find()->select('id')->where(['url' => $city])->asArray()->one();

        $params = explode('/', $params);

        $filter_params = FilterParams::find()->asArray()->all();

        $ids = array();

        $query_params = array();
        $bread_crumbs_params = array();

        $stem = 0;

        //Перебираем параметры
        foreach ($params as $value) {

            foreach ($filter_params as $filter_param){

                $result_id_array = array();

                if (strstr($value, $filter_param['url'])) {

                    $className = $filter_param['class_name'];
                    $classRelationName = $filter_param['relation_class'];

                    $url = self::prepareUrl($filter_param['url'],$value );

                    if ($url and $className) {

                        $id = $className::find()->where(['url' => $url])->asArray()->one();

                        if (isset($id['value'])){
                            $bread_crumbs_params[] = [
                                'url' => '/' . $value,
                                'label' => $id['value']
                            ];
                        }

                        if ($id and $classRelationName) {

                            if (!empty($ids)) {

                                $relationsIds = ArrayHelper::getColumn($classRelationName::find()
                                    ->where([$filter_param['column_param_name'] => $id['id']])
                                    ->andWhere(['city_id' => $city['id']])
                                    ->asArray()->all(), 'post_id');

                                $ids = array_intersect($ids, $relationsIds) ;

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

        }

        if (strstr($value, 'vozrast')) {

            $url = str_replace('vozrast-', '', $value);

            $age_params = array();

            if ($url == 'ot-20-let') {
                $bread_crumbs_params[] = [
                    'url' => '/vozrast-ot-20-let',
                    'label' => 'от 20 лет'
                ];
                $age_params[] = ['<=', 'birthday', \time() - 24 * 3600 * 365 * 20];
            }

            if ($url == 'ot-30-let') {
                $bread_crumbs_params[] = [
                    'url' => '/vozrast-ot-30-let',
                    'label' => 'от 30 лет'
                ];
                $age_params[] = ['<=', 'birthday', \time() - 24 * 3600 * 365 * 30];
            }

            if ($url == 'ot-40-let') {
                $bread_crumbs_params[] = [
                    'url' => '/vozrast-ot-40-let',
                    'label' => 'от 40 лет'
                ];
                $age_params[] = ['<=', 'birthday', \time() - (24 * 3600 * 365 * 40)];
            }

            if ($url == 'ot-45-let') {
                $bread_crumbs_params[] = [
                    'url' => '/vozrast-ot-45-let',
                    'label' => 'от 45 лет'
                ];
                $age_params[] = ['<=', 'birthday', \time() - (24 * 3600 * 365 * 45)];
            }

            if ($url == 'ot-50-let') {
                $bread_crumbs_params[] = [
                    'url' => '/vozrast-ot-50-let',
                    'label' => 'от 50 лет'
                ];
                $age_params[] = ['<=', 'birthday', \time() - 24 * 3600 * 365 * 50];
            }

            if ($url == 'ot-60-let') {
                $bread_crumbs_params[] = [
                    'url' => '/vozrast-ot-60-let',
                    'label' => 'от 60 лет'
                ];
                $age_params[] = ['<=', 'birthday', \time() - 24 * 3600 * 365 * 60];
            }

            $id = Posts::find();

            foreach ($age_params as $age_param) {
                $id->andWhere($age_param);
            }

            $id = $id->asArray()->select('id')->all();


            if ($id) {

                if (!empty($ids)) {

                    foreach ($id as $id_item) {

                        $result[] = ArrayHelper::getValue($id_item, 'id');

                    }

                    $ids = array_intersect($ids, $result) ;

                } else {

                    foreach ($id as $id_item) {

                        $result[] = ArrayHelper::getValue($id_item, 'id');

                    }

                    $ids = $id;

                }

            }

        }

        if ($ids) {

            Yii::$app->params['result_id'] = $ids;

            $query_params[] = ['in', 'id', $ids];


        }

        if (!empty($query_params)) {

            return $query_params;

            $posts = Profile::find();

            foreach ($query_params as $item) {

                $posts->andWhere($item);

            }

            $posts = $posts->limit(12)->all();

            return $posts;

        }
    }

    public static function prepareUrl($url, $value){

        if ($url == $value) return $url;

        return str_replace($url. '-', '', $value);


    }
}