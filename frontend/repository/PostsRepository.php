<?php

namespace frontend\repository;

use common\models\Pol;
use frontend\components\helpers\GetOrderHelper;
use frontend\modules\user\models\Posts;
use yii\data\Pagination;
use Yii;

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
            'totalCount' => $countQuery->cache(3600 * 12)->count(),
            'forcePageParam' => false,
            'defaultPageSize' => Yii::$app->params['post_limit']
        ]);

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

}