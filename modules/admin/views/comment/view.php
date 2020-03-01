<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Comment */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="comment-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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
        ],
    ]) ?>

</div>
