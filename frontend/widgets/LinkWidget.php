<?php


namespace frontend\widgets;

use common\models\Link;
use yii\base\Widget;
use Yii;

class LinkWidget extends Widget
{
    public $url;

    public function run()
    {

        // Пробуем извлечь $data из кэша.
        $data = Yii::$app->cache->get('fast_link_key_cache_pref_'.$this->url);

        if ($data === false) {
            // $data нет в кэше, вычисляем заново
            $links = Link::find()
                ->where(['url' => $this->url])
                ->asArray()
                ->all();

            Yii::$app->cache->set(Yii::$app->params['fast_link_key_cache_pref'].'_'.$this->url, $data);
        }

        return $this->render('links', [
            'links' => $links
        ]);
    }
}