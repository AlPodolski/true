<?php

namespace frontend\repository;

use frontend\modules\user\models\Posts;
use frontend\modules\user\models\UserNational;
use frontend\modules\user\models\UserRayon;
use yii\helpers\ArrayHelper;

class HelperRepository
{
    public function getPostForHelper($postViewIds)
    {

        $posts = (new PostsRepository())->getByIdPosts($postViewIds);

        $nationals = array();
        $rayon = array();
        $price = array();
        $age = array();
        $city = '';

        foreach ($posts as $post){

            /* @var $post Posts */

            if ($post['nacionalnost']) $nationals[] = $post['nacionalnost'][0]['id'];
            if ($post['rayon']) $rayon[] = $post['rayon'][0]['id'];
            if ($post['age']) $age[] = $post['age'];
            if ($post['price']) $price[] = $post['price'];
            $city = $post['city_id'];

        }

        $ids = array();

        if ($nationals){

            $temp = UserNational::find()
                ->where(['in', 'national_id', $nationals])
                ->select('post_id')
                ->andWhere(['city_id' => $city])
                ->asArray()->all();

            $ids = ArrayHelper::getColumn($temp, 'post_id');

        }

        if ($rayon){

            $temp = UserRayon::find()
                ->where(['in', 'rayon_id', $rayon])
                ->select('post_id')
                ->andWhere(['city_id' => $city])
                ->asArray()->all();

            $temp = ArrayHelper::getColumn($temp, 'post_id');

            if (!empty($ids)) $ids = array_merge($ids, $temp);

            else $ids = $temp;

        }

        $minAge = 0;
        $maxAge = 0;

        if ($age){

            $minAge = $age[0];
            $maxAge = $age[0];

            foreach ($age as $item){

                if ($item < $minAge) $minAge = $item;
                if ($item > $maxAge) $maxAge = $item;

            }

        }

        $minPrice = 0;
        $maxPrice = 0;

        if ($price){

            $minPrice = $price[0];
            $maxPrice = $price[0];

            foreach ($price as $item){

                if ($item < $minPrice) $minPrice = $item;
                if ($item > $maxPrice) $maxPrice = $item;

            }

        }

        $post = Posts::find()->where(['in', 'id', $ids])->andWhere(['city_id' => $city]);

        if ($maxAge) {

            $post = $post->andWhere(['>=', 'age', $minAge]);
            $post = $post->andWhere(['<=', 'age', $maxAge]);

        }
        if ($minPrice) {

            $post = $post->andWhere(['>=', 'price', $minPrice]);
            $post = $post->andWhere(['<=', 'price', $maxPrice]);

        }

        return $post->limit(8)->orderBy('RAND()')->all();

    }
}