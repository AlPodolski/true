<?php

namespace frontend\helpers\shema;

use frontend\helpers\PostRatingHelper;
use frontend\modules\user\models\Posts;
use Yii;

class SingleProductShema
{

    /* @var Posts */
    private $post;
    private $reviews;

    public function __construct(Posts $post)
    {
        $this->post = $post;
        $this->reviews = PostRatingHelper::getReview($this->post->id);
    }

    public function make()
    {

        $photo = $this->getAvatar();
        $rating = $this->getRating();
        $review = $this->getReviews();

        $result = array(
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'aggregateRating' => $rating,
            'description' => $this->post->about,
            'name' => $this->post->name,
            'image' => $photo,
            'offers' => array(
                '@type' => 'Offer',
                'availability' => 'https://schema.org/InStock',
                'price' => $this->post->price,
                'priceCurrency' => 'RUR'
            ),
            'review' => $review
        );

        $result = json_encode($result);

        return '<script type="application/ld+json">'.$result.'</script>';

    }

    private function getReviews()
    {

        $result = array();

        if ($this->reviews){

            foreach ($this->reviews as $item){

                if (isset($item['author']['username'])) $author = $item['author']['username'];
                elseif ($item['name']) $author = $item['name'];
                else $author = 'Аноним';

                $temp = explode(' ', $item['text']);

                $name = '';

                if (isset($temp[0])) $name = $temp[0];
                if (isset($temp[1])) $name .= ' '.$temp[1];

                $data = array(
                    '@type' => 'Review',
                    'author' => $author,
                    'datePublished' => date('Y-d-m', $item['created_at']),
                    'reviewBody' => $item['text'],
                    'name' => $name,
                    'reviewRating' => array(
                        '@type' => 'Rating',
                        'bestRating' => '10',
                        'ratingValue' => $item['total_marc'],
                        'worstRating' => '0',
                    )
                );

                $result[] = $data;

            }

        }

        return $result;

    }

    private function getRating(): array
    {

        $reviews = $this->reviews;

        if ($reviews) {

            $sumReview = 0;
            $reviewCount = count($reviews);

            foreach ($reviews as $review) {
                $sumReview = $sumReview + $review['total_marc'];
            }

            $ratingValue = round($sumReview / $reviewCount, 1);

            $data = array(
                '@type' => 'AggregateRating',
                'ratingValue' => $ratingValue,
                'reviewCount' => $reviewCount,
                'bestRating' => '10'
            );

            return $data;

        }

        return [];

    }

    private function getAvatar()
    {

        if (isset($this->post['avatar']['file']) and $file = $this->post['avatar']['file']) {

            $thumbSrc = 'https://' . Yii::$app->request->hostName;

            $thumbSrc .= Yii::$app->imageCache->thumbSrc($file, '500_700');

            return $thumbSrc;

        }

        return false;

    }

}
