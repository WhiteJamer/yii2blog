<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Articles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Article', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'content:ntext',
            [
                'label' => 'Author',
                'format' => 'text',
                'value' => function($data){
                    return $data->author->username;
                }
            ],
            [
                'label' => 'Category',
                'format' => 'text',
                'value' => function($data){
                    return $data->category->name;
                }
            ],
            [
                    'label' => 'Image',
                    'format' => 'html',
                    'value' => function($data){
                        return Html::img($data->getImage(), ['width' => 100]);
                    }
            ],
            [
                'label' => 'Дата публикации',
                'format' => 'text',
                'value' => function($data){
                    return $data->getDate();
                }
            ],
            'views',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
