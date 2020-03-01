<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Comments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Comment', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'label' => 'Комментарий',
                'format' => 'text',
                'value' => function($data){
                    return $data->body;
                }
            ],
            [
                'label' => 'Дата и время',
                'format' => 'text',
                'value' => function($data){
                    return $data->getDate();
                }
            ],
            [
                'label' => 'Автор',
                'format' => 'text',
                'value' => function($data){
                    return $data->author->username;
                }
            ],
            [
                'label' => 'Статья',
                'format' => 'text',
                'value' => function($data){
                    return $data->article->title;
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
