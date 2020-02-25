<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Article */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="article-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Set-image', ['set-image', 'id' => $model->id], ['class' => 'btn btn-secondary']) ?>
        <?= Html::a('Set-category', ['set-category', 'id' => $model->id], ['class' => 'btn btn-secondary']) ?>
        <?= Html::a('Set-tags', ['set-tags', 'id' => $model->id], ['class' => 'btn btn-secondary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
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
            'pub_date',
            'views',
        ],
    ]) ?>

</div>
