<?php

/* @var $this yii\web\View */

$this->title = $tag->name . '| ' . Yii::$app->name;

use app\widgets\Sidebar;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\helpers\Url;
use yii\widgets\LinkPager;
?>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h2 class="text-uppercase text-center">Статьи с тегом - "<?= Html::encode($tag->name) ?>"</h2>
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
                                        <a href="<?= Url::toRoute(['site/tag', 'name' => $tag->name])?>" class="btn btn-info"><?=Html::encode($tag->name)?></a>
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

            <?= LinkPager::widget([
                'pagination' => $pagination,
            ]); ?>
        </div>
        <?= Sidebar::widget() ?>
    </div>
</div>