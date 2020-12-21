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
                            Yii::$app->params['breadcrumbs'][] = array(
                                'label'=> $id['value'],
                            );
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

        if (strstr($value, 'cena')){

            $url = str_replace('cena-', '', $value);

            $price_params = array();

            if ($url == 'do-1500') {
                Yii::$app->params['breadcrumbs'][] = array(
                    'label'=> 'цена до 1500',
                );
                $price_params[] = ['<', 'price' , 1500];
            }

            if ($url == 'ot-1500-do-2000') {
                $price_params[] = ['>=', 'price' , 1500];
                $price_params[] = ['<=', 'price' , 1999];
                Yii::$app->params['breadcrumbs'][] = array(
                    'label'=> 'цена от 1500 до 2000',
                );
            }
            if ($url == 'ot-2000-do-3000') {
                $price_params[] = ['>=', 'price' , 2000];
                $price_params[] = ['<=', 'price' , 2999];
                Yii::$app->params['breadcrumbs'][] = array(
                    'label'=> 'цена от 2000 до 3000',
                );
            }
            if ($url == 'ot-3000-do-6000') {
                $price_params[] = ['>=', 'price' , 3000];
                $price_params[] = ['<=', 'price' , 6000];
                Yii::$app->params['breadcrumbs'][] = array(
                    'label'=> 'цена от 3000 до 6000',
                );
            }

            if ($url == 'ot-6000') {
                Yii::$app->params['breadcrumbs'][] = array(
                    'label'=> 'цена от 6000',
                );
                $price_params[] = ['>=', 'price' , 6001];
            }

            $id = Posts::find()->select('id');

            foreach ($price_params as $price_param){
                $id->andWhere($price_param);
            }

            $id = $id->asArray()->all();

            if($id){

                $result = ArrayHelper::getColumn($id, 'id');

                if (!empty($ids)){

                    $ids = array_intersect($ids, $id);

                }else{

                    $ids = $result;

                }

            }

        }

        if (strstr($value, 'proverennye')){

            $id = Posts::find()->select('id')->where(['check_photo_status' => 1])->asArray()->all();

            Yii::$app->params['breadcrumbs'][] = array(
                'label'=> 'проверенные',
            );

            if($id){

                $result = ArrayHelper::getColumn($id, 'id');

                if (!empty($ids)){

                    $ids = array_intersect($ids, $id);

                }else{

                    $ids = $result;

                }

            }

        }

        if (strstr($value, 'novie')){

            $id = Posts::find()->select('id')->orderBy(['created_at' => SORT_DESC ])->asArray()->all();

            Yii::$app->params['breadcrumbs'][] = array(
                'label'=> 'Новые анкеты',
            );

            if($id){

                $result = ArrayHelper::getColumn($id, 'id');

                if (!empty($ids)){

                    $ids = array_intersect($ids, $id);

                }else{

                    $ids = $result;

                }

            }

        }

        if (strstr($value, 'video')){

            Yii::$app->params['breadcrumbs'][] = array(
                'label'=> 'анкеты видео',
            );

            $id = Posts::find()->select('id')->where(['IS NOT', 'video', null])->asArray()->all();

            if($id){

                $result = ArrayHelper::getColumn($id, 'id');

                if (!empty($ids)){

                    $ids = array_intersect($ids, $id);

                }else{

                    $ids = $result;

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