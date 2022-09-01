<?php

namespace frontend\repository;

use common\models\National;
use common\models\Pol;
use frontend\components\helpers\GetOrderHelper;
use frontend\models\Metro;
use frontend\models\UserMetro;
use frontend\modules\user\models\Posts;
use yii\data\Pagination;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class PostsRepository
{

    private $order;
    private $cityId;

    public function __construct($cityId = false)
    {
        $this->order = (new GetOrderHelper())->get();
        $this->cityId = $cityId;
    }

    public function getForMainPage(): array
    {
        $prPosts = Posts::find()->asArray()
            ->with('avatar', 'metro', 'partnerId', 'rayon', 'nacionalnost', 'city', 'gallery')
            ->where(['city_id' => $this->cityId])
            ->andWhere(['status' => Posts::POST_ON_PUPLICATION_STATUS])
            ->andWhere(['pol_id' => Pol::WOMAN_POL])
            ->limit(Yii::$app->params['post_limit'])
            ->orderBy($this->order);

        $countQuery = clone $prPosts;

        $pages = new Pagination([
            'totalCount' => $count = $countQuery->cache(3600 * 12)->count(),
            'forcePageParam' => false,
            'defaultPageSize' => Yii::$app->params['post_limit']
        ]);

        if (Yii::$app->request->get('page') and $count < ((Yii::$app->request->get('page') - 1) * Yii::$app->params['post_limit']))
            throw new NotFoundHttpException();

        $prPosts = $prPosts->offset($pages->offset)->all();

        return array('posts' => $prPosts, 'pages' => $pages);
    }

    public function getMorePostsForMainPage($page)
    {

        $posts = Posts::find()
            ->asArray()
            ->with('avatar', 'metro', 'partnerId', 'rayon', 'nacionalnost', 'gallery')
            ->where(['city_id' => $this->cityId])
            ->andWhere(['status' => Posts::POST_ON_PUPLICATION_STATUS])
            ->andWhere(['pol_id' => Pol::WOMAN_POL])
            ->orderBy($this->order)
            ->limit(Yii::$app->params['post_limit']);

        $posts->offset(Yii::$app->params['post_limit'] * $page);

        $posts = $posts->all();

        return $posts;
    }

    public function getByIdPosts($ids)
    {
        $posts = Posts::find()
            ->asArray()
            ->with('avatar', 'metro', 'partnerId', 'rayon', 'nacionalnost')
            ->where(['in' ,'id', $ids])
            ->orderBy($this->order)
            ->all();

        return $posts;
    }

    public function getPostWithMinPrice()
    {
        $post = Posts::find()
            ->where(['city_id' => $this->cityId])
            ->andWhere(['status' => Posts::POST_ON_PUPLICATION_STATUS])
            ->orderBy('price ASC')
            ->one();

        return $post;
    }

    public function getPostWithMaxPrice()
    {
        $post = Posts::find()
            ->where(['city_id' => $this->cityId])
            ->andWhere(['status' => Posts::POST_ON_PUPLICATION_STATUS])
            ->orderBy('price DESC')
            ->one();

        return $post;
    }

    public function getPostCount()
    {
        $count = Posts::find()
            ->where(['city_id' => $this->cityId])
            ->andWhere(['status' => Posts::POST_ON_PUPLICATION_STATUS])
            ->count();

        return $count;
    }

    public function getPostForMoreSingle($id, $price, $pol, $ref)
    {

        $postsIds = false;

        if ($ref){

            $dataRef = explode(':ref', $ref);

            $cacheTime = 3600 * 12;

            switch ($dataRef[0]) {

                case 'metro':

                    $data = UserMetro::find()
                        ->select('post_id')
                        ->where(['metro_id' => $dataRef[1]])
                        ->andWhere(['city_id' => $this->cityId])
                        ->cache($cacheTime)
                        ->all();

                    $postsIds = ArrayHelper::getColumn($data, 'post_id');

                    break;

                case 'nacionalnost':
                    $data = National::find()
                        ->select('id')
                        ->cache($cacheTime)->one();

                    $result = 'nacionalnost:'.$data->id;

                    break;

            }

        }

        $post = Posts::find()->where(['not in', 'id' , $id])
            ->with('gal', 'metro', 'avatar', 'place', 'service',
                'sites', 'rayon', 'nacionalnost',
                'cvet', 'strizhka', 'selphiCount', 'serviceDesc', 'partnerId')
            ->andWhere(['city_id' => $this->cityId])
            ->andWhere(['status' => Posts::POST_ON_PUPLICATION_STATUS])
            ->andWhere(['pol_id' => $pol])
            ->orderBy(['rand()' => SORT_DESC]);

        if ($postsIds){
            $post = $post->andWhere(['in', 'id', $postsIds]);
        }

        if ($price < 3000){
            $post = $post->andWhere(['<=', 'price', 3000]);
        }

        if ($price >= 3000 and $price <= 6000 ){
            $post = $post->andWhere(['<=', 'price', 6000]);
            $post = $post->andWhere(['>=', 'price', 3000]);
        }

        if ($price >= 6000 ){
            $post = $post->andWhere(['>=', 'price', 6000]);
        }

        $post = $post->asArray()->one();

        return $post;

    }

}