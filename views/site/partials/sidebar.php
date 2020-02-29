<?php
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="col-md-4" data-sticky_column>
    <div class="primary-sidebar">

        <aside class="widget">
            <h3 class="widget-title text-uppercase text-center">Популярные</h3>
            <?php foreach ($popular as $article): ?>
                <div class="popular-post">

                <a href="<?= Url::toRoute(['/site/article', 'id' => $article->id]) ?>" class="popular-img"><img src="<?= Html::encode($article->getImage())?>" alt="">

                    <div class="p-overlay"></div>
                </a>

                <div class="p-content">
                    <a href="<?= Url::toRoute(['/site/article', 'id' => $article->id]) ?>" class="text-uppercase"><?= Html::encode($article->title)?></a>
                    <span class="p-date"><?= Html::encode($article->getDate())?></span>
                </div>
            </div>
            <?php endforeach ?>

        </aside>
        <aside class="widget pos-padding">
            <h3 class="widget-title text-uppercase text-center">Последние статьи</h3>
            <?php foreach ($recent as $article): ?>
                <div class="thumb-latest-posts">

                    <div class="media">
                        <div class="media-left">
                            <a href="#" class="popular-img"><img src="<?= Html::encode($article->getImage())?>" alt="">
                                <div class="p-overlay"></div>
                            </a>
                        </div>
                        <div class="p-content">
                            <a href="#" class="text-uppercase"><?= Html::encode($article->title)?></a>
                            <span class="p-date"><?= Html::encode($article->getDate())?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </aside>
        <aside class="widget border pos-padding">
            <h3 class="widget-title text-uppercase text-center">Категории</h3>
            <ul>
                <?php foreach ($categories as $category): ?>
                    <li>
                        <a href="#"><?= Html::encode($category->name)?></a>
                        <span class="post-count pull-right"><?= Html::encode($category->getArticles()->count())?></span>
                    </li>
                <?php endforeach ?>
            </ul>
        </aside>
    </div>
</div>