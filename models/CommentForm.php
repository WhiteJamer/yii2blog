<?php


namespace app\models;


use Yii;
use yii\base\Model;

class CommentForm extends Model

{
    public $body;

    public function rules()
    {
        return [
            [['body'], 'required'],
        ];
    }

    public function addComment($article_id)
    {
        $comment = new Comment;
        $comment->body = $this->body;
        $comment->author_id = Yii::$app->user->id;
        $comment->article_id = $article_id;
        $comment->pub_date = date('Y-m-d H:i:s');
        return $comment->save();


    }


}