<?php


namespace frontend\widgets;

use aki\telegram\types\User;
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
        if (\strstr($this->url, '?page')) $this->url = \strstr($this->url, '?page', true);
        // Пробуем извлечь $data из кэша.
        $data = Yii::$app->cache->get('fast_link_key_cache_pref_'.$this->url);

        if ($data === false) {
            // $data нет в кэше, вычисляем заново
            $links = Link::find()->asArray();

            if (isset(Yii::$app->requestedParams)
                and $city = City::getCity(Yii::$app->requestedParams['city'])
            ) {

                $links = $links->where(['city_id' => $city['id']]);
                $links = $links->orWhere(['city_id' => 0]);

            }

            $links = $links->andWhere(['url' => $this->url])->all();

            Yii::$app->cache->set(Yii::$app->params['fast_link_key_cache_pref'].'_'.$this->url, $data);
        }

        if (\strstr(Yii::$app->request->url, '?')) $url = \strstr(Yii::$app->request->url, '?', true);
        else $url = Yii::$app->request->url;

        if (\strstr($url, 'metro')){

            if (!\strstr($url, 'cena')){

                array_unshift ($links , array(
                    'link' => $url.'/cena-do-3000',
                    'text' => ' + Дешевые возле этого метро'
                ));

            }

        }

        if (\strstr($url, 'rayon')){

            if (!\strstr($url, 'cena')){

                array_unshift ($links , array(
                    'link' => $url.'/cena-do-3000',
                    'text' => ' + Дешевые в этом районе'
                ));

            }

        }

        return $this->render('links', [
            'links' => $links
        ]);
    }
}