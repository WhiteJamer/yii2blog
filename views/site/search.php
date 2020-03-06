<?php

/* @var $this yii\web\View */

$this->title = 'Поиск | ' . Yii::$app->name;

use app\widgets\Sidebar;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
?>

<div class="container">
    <div class="row">
        <form action="" class="form-group">
            <input type="text" placeholder="Найти" class="form-control" name="search">
            <button type="submit" class="btn btn-primary mt-1">Найти</button>
        </form>
            <div class="col-md-8">
                <?php if($articles): ?>
                <h3 class="text-uppercase ">Результаты поиска</h3>
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
                                        <p><?= StringHelper::truncateWords($article->content, 20)?>
                                        </p>
                                    </div>
                                    <div class="tags">
                                        <?php foreach($article->tags as $tag): ?>
                                            <a href="<?= Url::toRoute(['site/tag', 'name' => $tag->name])?>" class="btn btn-default"><?=Html::encode($tag->name)?></a>
                                        <?php endforeach?>
                                    </div>
                                    <div class="social-share">
                                <span class="pull-left text-capitalize">
                                    <a href="#"><b><?= Html::encode($article->author->username)?></b></a>
                                    <?= Html::encode($article->getDate())?>
                                </span>
                                        <ul class="text-center pull-right">
                                            <li><a href="#"><i class="fa fa-eye"></i></a></li><?= Html::encode($article->views)?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endforeach ?>
                <?php else: ?>
                    <p>Поиск не дал результатов...</p>
                <?php endif ?>
            </div>
        <?= Sidebar::widget() ?>
    </div>
</div>