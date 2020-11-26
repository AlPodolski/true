<?php


namespace frontend\modules\user\models;

use Yii;
use yii\base\Model;

class ServiceReviewForm extends Model
{
    private $data = array();

    public function __get($name)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }
    }


    public function save($id)
    {
        if ($reviewItems = Yii::$app->request->post('ServiceReviewForm')){

            foreach ($reviewItems as $key => $value){

                $serviceReview = new ServiceReviews();

                $serviceReview->post_id = (int) $id;
                $serviceReview->service_id = (int) $key;
                $serviceReview->marc = (int) $value;

                $serviceReview->save();

            }

        }

        return true;

    }

}