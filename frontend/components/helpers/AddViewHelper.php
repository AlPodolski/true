<?php

namespace frontend\components\helpers;

use Yii;

class AddViewHelper
{
    public function add($id)
    {
        $cookies = Yii::$app->request->cookies;

        $postsIds = array();

        if ($viewPosts = $cookies->get('view_post')){

            $postsIds = \unserialize($viewPosts);

            if (!in_array($id, $postsIds)) $postsIds[] = $id;

        }else{

            $postsIds[] = $id;

        }

        // получение коллекции (yii\web\CookieCollection) из компонента "response"
        $cookiesResponse = Yii::$app->response->cookies;

        // добавление новой куки в HTTP-ответ
        $cookiesResponse->add(new \yii\web\Cookie([
            'name' => 'view_post',
            'value' => \serialize($postsIds),
            'expire' => time() + (3600 * 24 * 31)
        ]));

        return $postsIds;

    }
}