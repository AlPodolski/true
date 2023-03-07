<?php

namespace frontend\helpers\shema;

use frontend\repository\PostsRepository;
use Yii;

class CatalogProductShema
{

    private $city;
    private $title;
    private $des;
    private $img;

    private $postRepository;

    public function __construct($title, $des, $city)
    {
        $this->title = $title;
        $this->des = $des;
        $this->img = 'https://.'.\Yii::$app->params['site_addr'].'/thumbs/a15/480x672_78249_1024.jpg';
        $this->city = $city;

        $this->postRepository = new PostsRepository($this->city);

    }

    public function make()
    {

        $minPrice = $this->getMinPrice();
        $maxPrice = $this->getMaxPrice();

        $count = $this->getPostCount();

        $result = array(
            '@context' => 'https://schema.org/',
            '@type' => 'Product',
            'name' => $this->title,
            'image' => $this->img,
            'brand' => array(
                '@type'=> 'Brand',
                'name' => $this->title,
            ),
            'description' => $this->des,
            'sku' => $this->title,
            'mpn' => $this->title,
            'aggregateRating' => array(
                '@type' => 'AggregateRating',
                'bestRating' => 5,
                'ratingValue' => 5,
                'ratingCount' => 30,
            ),
            'offers' => array(
                '@type' => 'AggregateOffer',
                'lowPrice' => $minPrice,
                'highPrice' => $maxPrice,
                'offerCount' => $count,
                'priceCurrency' => "RUR",
            ),
        );

        $result = json_encode($result);

        return '<script type="application/ld+json">'.$result.'</script>';

    }

    private function getPostCount(){

        $count = Yii::$app->cache->get('post_count');

        if ($count === false) {
            // $data нет в кэше, вычисляем заново
            $count = $this->postRepository->getPostCount();

            // Сохраняем значение $data в кэше. Данные можно получить в следующий раз.
            Yii::$app->cache->set('post_count', $count);
        }

        return $count;

    }

    private function getMinPrice(){

        $post = Yii::$app->cache->get('post_min_price');

        if ($post === false) {
            // $data нет в кэше, вычисляем заново
            $post = $this->postRepository->getPostWithMinPrice();

            // Сохраняем значение $data в кэше. Данные можно получить в следующий раз.
            Yii::$app->cache->set('post_min_price', $post);
        }

        if ($post) return $post->price;

        return 1500;

    }

    private function getMaxPrice(){

        $post = Yii::$app->cache->get('post_max_price');

        if ($post === false) {
            // $data нет в кэше, вычисляем заново
            $post = $this->postRepository->getPostWithMaxPrice();

            // Сохраняем значение $data в кэше. Данные можно получить в следующий раз.
            Yii::$app->cache->set('post_max_price', $post);
        }

        if ($post) return $post->price;

        return 1500;

    }

}