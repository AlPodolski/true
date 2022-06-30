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

    public function __construct()
    {
        $this->order = (new GetOrderHelper())->get();
    }

    public function getForMainPage($cityId): array
    {
        $prPosts = Posts::find()->asArray()
            ->with('avatar', 'metro', 'partnerId', 'rayon', 'nacionalnost', 'city')
            ->where(['city_id' => $cityId])
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

    public function getMorePostsForMainPage($cityId, $page)
    {

        $posts = Posts::find()
            ->asArray()
            ->with('avatar', 'metro', 'partnerId', 'rayon', 'nacionalnost')
            ->where(['city_id' => $cityId])
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

}