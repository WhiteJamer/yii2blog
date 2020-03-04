<?php

use yii\helpers\Html;
use yii\helpers\StringHelper;
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
                'label' => 'Заголовок',
                'format' => 'html',
                'value' => function($data){
                    return Html::a($data->title, ['/site/article', 'id' => $data->id]);
                }
            ],
            [
                'label' => 'Контент',
                'format' => 'html',
                'value' => function($data){
                    return StringHelper::truncate($data->content, 100);
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
                'label' => 'Категория',
                'format' => 'html',
                'value' => function($data){
                    return Html::a($data->category->name, ['/site/category', 'id' => $data->category->id]);
                }
            ],
            [
                'label' => 'Теги',
                'format' => 'html',
                'value' => function($data){
                    $html = '';
                    foreach($data->tags as $tag){
                        $html = $html . Html::a($tag->name, ['/site/tag', 'name' => $tag->name]) . ", ";
                    }
                    return $html;
                }
            ],
            [
                'label' => 'Картинка',
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
            [
                'label' => 'Кол-во просмотров',
                'format' => 'text',
                'value' => function($data){
                    return $data->views;
                }
            ],
        ],
    ]) ?>

</div>
