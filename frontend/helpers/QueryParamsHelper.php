<?php


namespace frontend\helpers;


use common\models\City;
use common\models\Pol;
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

        $polSearch = false;

        //Перебираем параметры
        foreach ($params as $value) {

            foreach ($filter_params as $filter_param){

                $result_id_array = array();

                if (strstr($value, $filter_param['url'])) {

                    $className = $filter_param['class_name'];
                    $classRelationName = $filter_param['relation_class'];

                    $url = self::prepareUrl($filter_param['url'],$value );

                    if ($url and $className and $classRelationName) {

                        $id = $className::find()->where(['url' => $url, 'city_id' => $city['id']])->asArray()->one();

                        if (isset($id['value'])){
                            Yii::$app->params['breadcrumbs'][] = array(
                                'label'=> $id['value'],
                                'url'=> '/'.$value,
                            );
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

            if (\strstr($value, 'vozrast')){

                $url = str_replace('vozrast-', '', $value);

                $ageRange = \explode('-', $url );

                if (\is_array($ageRange) and (\count($ageRange) == 2) ){

                    $id = Posts::find()
                        ->select('id')
                        ->where(['>', 'age', $ageRange[0]])
                        ->andWhere(['<' , 'age', $ageRange[1]])
                        ->asArray()
                        ->all();

                    $ids = self::intersect_data($id, $ids);

                }

            }

            if (strstr($value, 'cena')){

                $url = str_replace('cena-', '', $value);

                $price_params = array();

                if ($url == 'do-1500') {
                    Yii::$app->params['breadcrumbs'][] = array(
                        'label'=> 'цена до 1500',
                    );
                    $price_params[] = ['<', 'price' , 1501];
                }

                if ($url == 'do-3000') {
                    Yii::$app->params['breadcrumbs'][] = array(
                        'label'=> 'цена до 3000',
                        'url'=> Yii::$app->params['breadcrumbs'] ? 'cena-do-3000' : '/cena-do-3000',
                    );
                    $price_params[] = ['<', 'price' , 3001];
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

                $ids = self::intersect_data($id, $ids);

            }

            if (strstr($value, 'rost')){

                $url = str_replace('rost-', '', $value);

                $price_params = array();

                if ($url == 'visokii') {
                    Yii::$app->params['breadcrumbs'][] = array(
                        'label'=> 'Высокие',
                        'url'=> Yii::$app->params['breadcrumbs'] ? 'rost-visokii' : '/rost-visokii',
                    );
                    $price_params[] = ['>', 'rost' , 179];
                }

                if ($url == 'srednii') {
                    Yii::$app->params['breadcrumbs'][] = array(
                        'label'=> 'Среднего роста',
                        'url'=> Yii::$app->params['breadcrumbs'] ? 'rost-srednii' : '/rost-srednii',
                    );
                    $price_params[] = ['>=', 'rost' , 158];
                    $price_params[] = ['<', 'rost' , 180];
                }

                if ($url == 'nizkii') {
                    Yii::$app->params['breadcrumbs'][] = array(
                        'label'=> 'Низкие',
                        'url'=> Yii::$app->params['breadcrumbs'] ? 'rost-nizkii' : '/rost-nizkii',
                    );
                    $price_params[] = ['<', 'rost' , 157];
                }

                $id = Posts::find()->select('id');

                foreach ($price_params as $price_param){
                    $id->andWhere($price_param);
                }

                $id = $id->asArray()->all();

                $ids = self::intersect_data($id, $ids);

            }

            if (strstr($value, 'ves')){

                $url = str_replace('ves-', '', $value);

                $price_params = array();

                if ($url == 'tolstye') {
                    Yii::$app->params['breadcrumbs'][] = array(
                        'label'=> 'Высокие',
                        'url'=> Yii::$app->params['breadcrumbs'] ? 'ves-tolstye' : '/rost-tolstye',
                    );
                    $price_params[] = ['>', 'ves' , 80];
                }

                if ($url == 'hudye') {
                    Yii::$app->params['breadcrumbs'][] = array(
                        'label'=> 'Высокие',
                        'url'=> Yii::$app->params['breadcrumbs'] ? 'ves-hudye' : '/rost-hudye',
                    );
                    $price_params[] = ['<', 'ves' , 60];

                }

                $id = Posts::find()->select('id');

                foreach ($price_params as $price_param){
                    $id->andWhere($price_param);
                }

                $id = $id->asArray()->all();

                $ids = self::intersect_data($id, $ids);

            }

            if (strstr($value, 'proverennye')){

                $id = Posts::find()->select('id')->where(['check_photo_status' => 1])->asArray()->all();

                Yii::$app->params['breadcrumbs'][] = array(
                    'label'=> 'проверенные',
                );

                $ids = self::intersect_data($id, $ids);

            }

            if (strstr($value, 'novie')){

                $id = Posts::find()->select('id')->orderBy(['created_at' => SORT_DESC ])->asArray()->all();

                Yii::$app->params['breadcrumbs'][] = array(
                    'label'=> 'Новые анкеты',
                );

                $ids = self::intersect_data($id, $ids);

            }

            if (strstr($value, 'salon')){

                $id = Posts::find()->select('id')->where(['category' => Posts::SALON_CATEGORY])->asArray()->all();

                Yii::$app->params['breadcrumbs'][] = array(
                    'label'=> 'Интим салоны',
                );

                $ids = self::intersect_data($id, $ids);

            }

            if (strstr($value, 'pol-')){

                $polSearch = true;

                $url = str_replace('pol-', '', $value);

                $pol = Pol::findOne(['url' => $url]);

                $id = Posts::find()->select('id')->where(['pol_id' => $pol['id']])->asArray()->all();

                Yii::$app->params['breadcrumbs'][] = array(
                    'label'=> 'Пол '.$pol['value'],
                );

                $ids = self::intersect_data($id, $ids);

            }

            if ($value == 'video'){

                Yii::$app->params['breadcrumbs'][] = array(
                    'label'=> 'анкеты видео',
                );

                $id = Posts::find()->select('id')->where(['<>', 'video', ''])->asArray()->all();

                $ids = self::intersect_data($id, $ids);

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

    private static function intersect_data($id, $ids){

        if($id){

            $result = ArrayHelper::getColumn($id, 'id');

            if (!empty($ids)){

                $ids = array_intersect($ids, $result);

            }else{

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

    public static function prepareUrl($url, $value){

        if ($url == $value) return $url;

        return str_replace($url. '-', '', $value);
    }

}