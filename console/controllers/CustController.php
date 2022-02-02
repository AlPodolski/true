<?php


namespace console\controllers;

use common\models\City;
use common\models\Rayon;
use frontend\modules\user\models\Posts;
use frontend\modules\user\models\UserRayon;
use League\Csv\Reader;
use League\Csv\Statement;
use Yii;
use yii\console\Controller;

class CustController extends Controller
{
    public function actionIndex()
    {
        $cityList = array('Архангельск' , 'Астрахань' , 'Барнаул' , 'Белгород' , 'Братск' , 'Брянск' , 'Владивосток' , 'Владикавказ' , 'Владимир' , 'Волгоград' , 'Воронеж' , 'Грозный' , 'Екатеринбург' , 'Иваново' , 'Ижевск' , 'Иркутск' , 'Казань' , 'Калининград' , 'Калуга' , 'Каменск-Уральский' , 'Кемерово' , 'Киров' , 'Комсомольск-на-Амуре' , 'Кострома' , 'Краснодар' , 'Красноярск' , 'Курск' , 'Липецк' , 'Магнитогорск' , 'Махачкала' , 'Мурманск' , 'Набережные Челны' , 'Назрань' , 'Нижний Новгород' , 'Нижний Тагил' , 'Новокузнецк' , 'Новороссийск' , 'Новосибирск' , 'Норильск' , 'Омск' , 'Орёл' , 'Оренбург' , 'Орск' , 'Пенза' , 'Пермь' , 'Прокопьевск' , 'Рязань' , 'Самара' , 'Саранск' , 'Саратов' , 'Севастополь' , 'Симферополь' , 'Смоленск' , 'Сочи' , 'Ставрополь' , 'Сыктывкар' , 'Тамбов' , 'Тверь' , 'Тольятти' , 'Томск' , 'Тула' , 'Тюмень' , 'Улан-Удэ' , 'Ульяновск' , 'Уфа' , 'Хабаровск' , 'Чебоксары' , 'Челябинск' , 'Чита' , 'Якутск' , 'Ярославль');

        foreach ($cityList as $item){

            if ($cityInfo = City::findOne(['city' => $item]) and $rayonList = Rayon::findAll(['city_id' => $cityInfo['id']])){

                if ($postsList = Posts::findAll(['city_id' => $cityInfo['id']])){

                    foreach ($postsList as $postItem){

                        $rayon = $rayonList[\array_rand($rayonList)];

                        $userRayon = new UserRayon();

                        $userRayon->city_id = $cityInfo['id'];
                        $userRayon->rayon_id = $rayon['id'];
                        $userRayon->post_id = $postItem['id'];

                        $postItem->save();

                    }

                }

            }

        }

    }
}