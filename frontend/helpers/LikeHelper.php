<?php

namespace frontend\helpers;

use Yii;

class LikeHelper
{
    public static function isLike($id): bool
    {
        $cookiesRequest = Yii::$app->request->cookies;

        $favorite = $cookiesRequest->getValue('liked');

        $items = \unserialize($favorite);


        if (\is_array($items) and \in_array($id, $items)) {

            return true;

        }

        return false;

    }

    public static function isDislike($id): bool
    {

        $cookiesRequest = Yii::$app->request->cookies;

        $favorite = $cookiesRequest->getValue('disliked');

        $items = \unserialize($favorite);

        if (\is_array($items) and \in_array($id, $items)) {

            return true;

        }

        return false;

    }

    public static function add($id, $type)
    {

        $cookiesRequest = Yii::$app->request->cookies;

        $favorite = $cookiesRequest->getValue($type);

        $cookies = Yii::$app->response->cookies;

        if (!$favorite) {

            $item = \serialize(array($id));

            $cookies->add(new \yii\web\Cookie([
                'name' => $type,
                'value' => $item,
                'expire' => \time() + (3600 * 24 * 365),
            ]));

        } else {

            $items = \unserialize($favorite);

            $items[] = $id;

            $items = \serialize($items);

            $cookies->add(new \yii\web\Cookie([
                'name' => $type,
                'value' => $items,
                'expire' => \time() + (3600 * 24 * 365),
            ]));

        }

    }

    public static function remove($id, $type)
    {
        $cookiesRequest = Yii::$app->request->cookies;

        $favorite = $cookiesRequest->getValue($type);

        $cookies = Yii::$app->response->cookies;


        $items = \unserialize($favorite);

        if (\in_array($id, $items)) {

            foreach ($items as $key => $item) {

                if ($item == $id) unset($items[$key]);

            }

        }

        $items = \serialize($items);

        $cookies->add(new \yii\web\Cookie([
            'name' => $type,
            'value' => $items,
            'expire' => \time() + (3600 * 24 * 365),
        ]));


    }
}