<?php


namespace frontend\components;

use yii\authclient\clients\VKontakte;

class Vk extends VKontakte
{
    public $attributeNames = [
        'uid',
        'first_name',
        'last_name',
        'nickname',
        'screen_name',
        'sex',
        'bdate',
        'city',
        'country',
        'timezone',
        'email',
        'photo_max_orig'
    ];

    /**
     * {@inheritdoc}
     */
    public function applyAccessTokenToRequest($request, $accessToken)
    {
        $data = $request->getData();
        $data['v'] = $this->apiVersion;
        $data['user_ids'] = $accessToken->getParam('user_id');
        $data['access_token'] = $accessToken->getToken();
        $data['scope'] = 'email';
        $request->setData($data);
    }
}