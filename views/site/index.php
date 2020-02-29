<?php

/* @var $this yii\web\View */

$this->title = Yii::$app->name;

use app\widgets\Sidebar;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
?>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <?php foreach ($articles as $article): ?>
                <article class="post">
                    <div class="post-thumb">
                        <a href="<?= Url::toRoute(['site/article', 'id' => $article->id])?>"><img src="<?= Html::encode($article->getImage())?>" alt=""></a>

                        <a href="<?= Url::toRoute(['site/article', 'id' => $article->id])?>" class="post-thumb-overlay text-center">
                            <div class="text-uppercase text-center">View Post</div>
                        </a>
                    </div>
                    <div class="post-content">
                        <header class="entry-header text-center text-uppercase">
                            <h6><a href="<?= Url::toRoute(['site/category', 'id' => $article->category->id])?>"><?= Html::encode($article->category->name)?></a></h6>

                            <h1 class="entry-title"><a href="<?= Url::toRoute(['site/article', 'id' => $article->id])?>"><?= Html::encode($article->title)?></a></h1>


                        </header>
                        <div class="entry-content">
                            <p><?= Html::encode($article->content)?>
                            </p>

                            <div class="btn-continue-reading text-center text-uppercase">
                                <a href="<?= Url::toRoute(['site/article', 'id' => $article->id])?>" class="more-link">Continue Reading</a>
                            </div>
                        </div>
                        <div class="social-share">
                            <span class="social-share-title pull-left text-capitalize">By <a href="#"><?= $article->author->username ?></a> On <?= $article->getDate()?></span>
                            <ul class="text-center pull-right">
                                <li><a class="s-facebook" href="#"><i class="fa fa-eye"></i></a></li><?= Html::encode($article->views)?>
                            </ul>
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