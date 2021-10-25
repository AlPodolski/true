<?php

namespace common\components\helpers;

use common\models\User;
use frontend\modules\user\models\Posts;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class TelegramChanelHelper
{
    public static function sendPostToChanel(Posts $post)
    {

        Yii::$app->telegramChanel->sendMediaGroup([

            'chat_id' => Yii::$app->params['telegramChanelId'],

            'media' => \json_encode(self::preparePostInfo($post)),

        ]);
    }

    public static function preparePostInfo(Posts $post)
    {

        return (\array_merge($data[] = self::prepareAvatarAndTextInfo($post), self::prepareMedia($post)));

    }

    public static function prepareMedia(Posts $post): array
    {

        $result = array();

        if ($postPhotoFiles = ArrayHelper::getColumn($post->gallery, 'file')) {

            foreach ($postPhotoFiles as $item) {

                $result[] = [
                    'type' => 'photo',
                    'media' => 'https://moskva.sex-true.com'.$item
                ];

            }

        }

        return $result;

    }

    public static function prepareAvatarAndTextInfo(Posts $post): array
    {
        return array(
            'type' => 'photo',
            'parse_mode' => 'html',
            'caption' => self::prepareTextAboutPost($post),
            'media' => 'https://moskva.sex-true.com'.$post->avatar->file
        );
    }

    public static function prepareTextAboutPost(Posts $post): string
    {
        $result = $post->name . '  '. \PHP_EOL;

        if ($post->breast) $result .= 'Грудь ' . $post->breast . '  ' . \PHP_EOL;

        if ($post->rost) $result .= 'Рост ' . $post->rost . '  ' . \PHP_EOL;

        if ($post->rost) $result .= 'Возраст ' . $post->age . '  ' . \PHP_EOL;

        if ($post->price) $result .= 'Цена ' . $post->price . '  ' . \PHP_EOL;

        if ($post->about) $result .= 'Обо мне ' . $post->about . '' . \PHP_EOL;

        if ($post->phone) $result .= 'Номер +' . $post->phone;

        return $result;
    }

}