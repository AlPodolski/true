<?php

namespace common\components\helpers;

use common\models\User;
use frontend\modules\user\models\Posts;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class TelegramChanelHelper
{
    public static function sendPostToChanel($media)
    {

        return Yii::$app->telegramChanel->sendMediaGroup([

            'chat_id' => Yii::$app->params['telegramChanelId'],

            'media' => $media,

        ]);
    }

    public static function preparePostInfo(Posts $post)
    {

        $postAvatar = self::prepareAvatarAndTextInfo($post);

        $postMedia = self::prepareMedia($post);

        $resultData = \array_merge($postMedia, $postAvatar);

        $resultData = \json_encode($resultData);

        return $resultData;

    }

    public static function prepareMedia(Posts $post): array
    {

        $result = array();

        if ($postPhotoFiles = ArrayHelper::getColumn($post->gallery, 'file')) {

            $i = 0;

            foreach ($postPhotoFiles as $item) {

                $result[] = [
                    'type' => 'photo',
                    'media' => 'https://moskva4.sex-tut.com'.Yii::$app->imageCache->thumbSrc($item, '500_700')
                ];

                $i++;

                if ($i >= 3) break;

            }

        }

        return $result;

    }

    public static function prepareAvatarAndTextInfo(Posts $post): array
    {
        return array(0 => [
            'type' => 'photo',
            'parse_mode' => 'html',
            'caption' => self::prepareTextAboutPost($post),
            'media' => 'https://moskva4.sex-tut.com'.Yii::$app->imageCache->thumbSrc($post->avatar->file, '500_700')
        ]
        );
    }

    public static function prepareTextAboutPost(Posts $post): string
    {
        $result = $post->name . ' ✅ '. \PHP_EOL;

        $about = strip_tags($post->about);

        if ($post->breast) $result .= 'Грудь: ' . $post->breast . '  ' . \PHP_EOL;

        if ($post->rost) $result .= 'Рост: ' . $post->rost . '  ' . \PHP_EOL;

        if ($post->rost) $result .= 'Возраст: ' . $post->age . '  ' . \PHP_EOL;

        if ($post->price) $result .= 'Цена: ' . $post->price . '  ' . \PHP_EOL;

        if ($post->about) $result .= 'Обо мне: ' . $about . ' ' . \PHP_EOL;

        if ($post->phone) $result .= 'Номер: +' . $post->phone . \PHP_EOL;

        $result .= '<a href="https://moskva4.sex-tut.com/post/'.$post->id.'">Подробнее</a>';

        return $result;
    }

}