<?php

/* @var $this yii\web\View */

$this->title = $category->name . ' категория | ' . Yii::$app->name;

use app\widgets\Sidebar;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\widgets\LinkPager;
?>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <?php foreach($articles as $article): ?>
                <article class="post post-list">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="post-thumb">
                                <a href="<?= Url::toRoute(['site/article', 'id' => $article->id])?>"><img src="<?= $article->getImage() ?>" alt="image" class="pull-left"></a>

                                <a href="<?= Url::toRoute(['site/article', 'id' => $article->id])?>" class="post-thumb-overlay text-center">
                                    <div class="text-uppercase text-center">View Post</div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="post-content">
                                <header class="entry-header text-uppercase">
                                    <h6><a href="<?= Url::toRoute(['site/category', 'id' => $article->category->id])?>"><?= $article->category->name ?></a></h6>

                                    <h1 class="entry-title"><a href="<?= Url::toRoute(['site/article', 'id' => $article->id])?>"><?= Html::encode($article->title)?></a></h1>
                                </header>
                                <div class="entry-content">
                                    <p><?= StringHelper::truncateWords(Html::encode($article->content), 20)?>
                                    </p>
                                </div>
                                <div class="social-share">
                                    <span class="social-share-title pull-left text-capitalize">By <?= Html::encode($article->author->username)?> On <?= Html::encode($article->getDate())?></span>

                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            <?php endforeach ?>

            <?= LinkPager::widget([
                'pagination' => $pagination,
            ]); ?>
        </div>
        <?= Sidebar::widget() ?>
    </div>
</div>