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

    public function rules()
    {
        return [
            [['post_id', 'reason'], 'integer'],
            [['post_id', 'reason'], 'required'],
            [['text'], 'string'],
            [['email'], 'email'],
        ];
    }

    public function save()
    {
        $claim = new AnketClaim();

        $claim->post_id = $this->post_id;
        $claim->reason_id = $this->reason;
        $claim->text = $this->text;
        $claim->email = $this->email;

        return $claim->save();
    }
    
}