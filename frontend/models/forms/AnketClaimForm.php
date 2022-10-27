<?php


namespace frontend\models\forms;

use common\models\AnketClaim;
use yii\base\Model;

class AnketClaimForm extends Model
{
    public $post_id;
    public $reason;
    public $text;
    public $email;
    public $ip;

    public function rules()
    {
        return [
            [['post_id', 'reason'], 'integer'],
            [['post_id', 'reason'], 'required'],
            [['text'], 'string'],
            [['email'], 'email'],
            [['ip'], 'validateIp'],
        ];
    }

    public function validateIp($attribute)
    {
        if (!$this->hasErrors()) {

            $ip = AnketClaim::find()->where(['ip' => $this->ip])
                ->andWhere(['>', 'created_at', time() - (3600 * 24 * 7)])->count();

            if ($ip > 2) {

                $this->addError($attribute, 'Много запросов');

            }

        }
    }

    public function save()
    {
        $claim = new AnketClaim();

        $claim->post_id = $this->post_id;
        $claim->reason_id = $this->reason;
        $claim->text = $this->text;
        $claim->email = $this->email;
        $claim->ip = $this->ip;

        return $claim->save();
    }
    
}