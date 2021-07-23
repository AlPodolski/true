<?php


namespace frontend\widgets;

use common\models\City;
use common\models\Link;
use frontend\models\Metro;
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
                ->asArray();

            if (isset(Yii::$app->requestedParams)
                and $city = City::getCity(Yii::$app->requestedParams['city'])
            ) {

                $links = $links->andWhere(['city_id' => $city['id']]);
                $links = $links->orWhere(['city_id' => 0]);

            }

                $links = $links->all();

            Yii::$app->cache->set(Yii::$app->params['fast_link_key_cache_pref'].'_'.$this->url, $data);
        }

        return $this->render('links', [
            'links' => $links
        ]);
    }
}