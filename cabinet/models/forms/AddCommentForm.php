<?php


namespace cabinet\models\forms;

use yii\base\Model;
use common\models\Comments;


class AddCommentForm extends Model
{
    public $text;
    public $class;
    public $related_id;
    public $created_at;
    public $author_id;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['author_id', 'created_at', 'related_id'], 'integer'],
            [['class'], 'string', 'max' => 120],
            [['text'], 'string', 'max' => 255, 'min' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'text' => 'Text',
        ];
    }

    public function save(){

        $comment = new Comments();

        $comment->author_id = $this->author_id;
        $comment->text = $this->text;
        $comment->class = $this->class;
        $comment->related_id = $this->related_id;
        $comment->created_at = $this->created_at;

        $comment->save();

        return $comment->id;

    }
}