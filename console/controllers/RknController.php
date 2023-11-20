<?php

namespace console\controllers;

use common\models\City;
use common\models\CityBlock;
use Yii;

/**
 *
 * @property-read mixed $data
 */
class RknController extends \yii\console\Controller
{
    public function actionIndex()
    {

        $result = $this->getData();

        $cityList = City::find()->all();

        $domains = array();

        foreach ($cityList as $cityItem) {
            $domains[] = $cityItem->domain;
        }

        $domains = array_unique($domains);

        $blockDomains = $this->getBlockCity($result, $domains, $cityList);

        if ($blockDomains) {

            if (isset($blockDomains['city'])) {

                foreach ($blockDomains['city'] as $blockCityItem) {

                    $this->prepareAddNewBlock($blockCityItem);

                }

            }

        }

    }

    private function prepareAddNewBlock($blockCityItem){

        $blockCityItemNum = preg_replace('/[^0-9]+/', '', $blockCityItem);

        if ($blockCityItemNum) {

            $cityUrl = preg_replace('/[0-9]+/', '', $blockCityItem);

            $blockCityItemNum = $blockCityItemNum + 1;

            $newCityUrl = $cityUrl . $blockCityItemNum;

        } else {

            $cityUrl = $blockCityItem;

            $newCityUrl = $cityUrl . 1;

        }

        $this->addNewBlock($cityUrl, $blockCityItem, $newCityUrl);

    }

    private function addNewBlock($cityUrl, $blockCityItem, $newCityUrl)
    {

        $cityInfo = City::find()->where(['url' => $cityUrl])->one();

        if (!CityBlock::find()->where(['old_city' => $blockCityItem])->one()) {

            $newCityBlock = new CityBlock();

            $newCityBlock->old_city = $blockCityItem;
            $newCityBlock->new_city = $newCityUrl;
            $newCityBlock->city_id = $cityInfo->id;
            $newCityBlock->created_at = time();

            $newCityBlock->save();

        }

    }

    private function getBlockCity($allBlockSites, $domains, $cityList): array
    {

        $blockDomains = array();

        if ($allBlockSites) {

            foreach ($allBlockSites as $key => $value) {

                foreach ($domains as $domain) {

                    if ($value == $domain) {

                        $blockDomains['domain'][] = $domain;

                    }

                    if (strpos($value, $domain)) {

                        foreach ($cityList as $cityItem) {

                            if ($cityItem->actual_city) {

                                $tempName = $cityItem->actual_city . '.' . $cityItem->domain;

                                if ($value == $tempName) {

                                    $blockDomains['city'][] = $cityItem->actual_city;

                                }
                            } else {

                                $tempName = $cityItem->url . '.' . $cityItem->domain;

                                if ($value == $tempName) {

                                    $blockDomains['city'][] = $cityItem->url;

                                }

                            }

                        }

                    }

                }

            }

        }

        return $blockDomains;

    }

    private function getData()
    {

        $result = Yii::$app->cache->get('rkn');

        if ($result === false) {

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://reestr.rublacklist.net/api/v3/domains/");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $server_output = curl_exec($ch);

            $result = json_decode($server_output);
            // Сохраняем значение $data в кэше. Данные можно получить в следующий раз.
            Yii::$app->cache->set('rkn', $result, 3600);

        }

        return $result;

    }
}