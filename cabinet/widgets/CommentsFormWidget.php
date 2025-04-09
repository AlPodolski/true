<?php


namespace cabinet\widgets;


use yii\base\Widget;
use cabinet\models\forms\AddCommentForm;

class CommentsFormWidget extends Widget
{

    public $classRelatedModel;
    public $classCss;
    public $idCss;
    public $relatedId;

    public function run()
    {
        $commentForm = new AddCommentForm();

        return $this->render('comment_form', [
            'classRelatedModel' => $this->classRelatedModel,
            'commentForm' => $commentForm,
            'classCss' => $this->classCss,
            'idCss' => $this->idCss,
            'relatedId' => $this->relatedId,
        ]);
    }
}