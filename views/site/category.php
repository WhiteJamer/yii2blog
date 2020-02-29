<?php

/* @var $this yii\web\View */

$this->title = $category->name . ' категория | ' . Yii::$app->name;

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
        <div class="col-md-4" data-sticky_column>
            <div class="primary-sidebar">

                <aside class="widget">
                    <h3 class="widget-title text-uppercase text-center">Popular Posts</h3>

                    <div class="popular-post">


                        <a href="#" class="popular-img"><img src="assets/images/p1.jpg" alt="">

                            <div class="p-overlay"></div>
                        </a>

                        <div class="p-content">
                            <a href="#" class="text-uppercase">Home is peaceful Place</a>
                            <span class="p-date">February 15, 2016</span>

                        </div>
                    </div>
                    <div class="popular-post">

                        <a href="#" class="popular-img"><img src="assets/images/p1.jpg" alt="">

                            <div class="p-overlay"></div>
                        </a>

                        <div class="p-content">
                            <a href="#" class="text-uppercase">Home is peaceful Place</a>
                            <span class="p-date">February 15, 2016</span>
                        </div>
                    </div>
                    <div class="popular-post">


                        <a href="#" class="popular-img"><img src="assets/images/p1.jpg" alt="">

                            <div class="p-overlay"></div>
                        </a>

                        <div class="p-content">
                            <a href="#" class="text-uppercase">Home is peaceful Place</a>
                            <span class="p-date">February 15, 2016</span>
                        </div>
                    </div>
                </aside>
                <aside class="widget pos-padding">
                    <h3 class="widget-title text-uppercase text-center">Recent Posts</h3>

                    <div class="thumb-latest-posts">


                        <div class="media">
                            <div class="media-left">
                                <a href="#" class="popular-img"><img src="assets/images/r-p.jpg" alt="">

                                    <div class="p-overlay"></div>
                                </a>
                            </div>
                            <div class="p-content">
                                <a href="#" class="text-uppercase">Home is peaceful Place</a>
                                <span class="p-date">February 15, 2016</span>
                            </div>
                        </div>
                    </div>
                    <div class="thumb-latest-posts">


                        <div class="media">
                            <div class="media-left">
                                <a href="#" class="popular-img"><img src="assets/images/r-p.jpg" alt="">

                                    <div class="p-overlay"></div>
                                </a>
                            </div>
                            <div class="p-content">
                                <a href="#" class="text-uppercase">Home is peaceful Place</a>
                                <span class="p-date">February 15, 2016</span>
                            </div>
                        </div>
                    </div>
                    <div class="thumb-latest-posts">


                        <div class="media">
                            <div class="media-left">
                                <a href="#" class="popular-img"><img src="assets/images/r-p.jpg" alt="">

                                    <div class="p-overlay"></div>
                                </a>
                            </div>
                            <div class="p-content">
                                <a href="#" class="text-uppercase">Home is peaceful Place</a>
                                <span class="p-date">February 15, 2016</span>
                            </div>
                        </div>
                    </div>
                    <div class="thumb-latest-posts">


                        <div class="media">
                            <div class="media-left">
                                <a href="#" class="popular-img"><img src="assets/images/r-p.jpg" alt="">

                                    <div class="p-overlay"></div>
                                </a>
                            </div>
                            <div class="p-content">
                                <a href="#" class="text-uppercase">Home is peaceful Place</a>
                                <span class="p-date">February 15, 2016</span>
                            </div>
                        </div>
                    </div>
                </aside>
                <aside class="widget border pos-padding">
                    <h3 class="widget-title text-uppercase text-center">Categories</h3>
                    <ul>
                        <li>
                            <a href="#">Food & Drinks</a>
                            <span class="post-count pull-right"> (2)</span>
                        </li>
                        <li>
                            <a href="#">Travel</a>
                            <span class="post-count pull-right"> (2)</span>
                        </li>
                        <li>
                            <a href="#">Business</a>
                            <span class="post-count pull-right"> (2)</span>
                        </li>
                        <li>
                            <a href="#">Story</a>
                            <span class="post-count pull-right"> (2)</span>
                        </li>
                        <li>
                            <a href="#">DIY & Tips</a>
                            <span class="post-count pull-right"> (2)</span>
                        </li>
                        <li>
                            <a href="#">Lifestyle</a>
                            <span class="post-count pull-right"> (2)</span>
                        </li>
                    </ul>
                </aside>
                <aside class="widget pos-padding">
                    <h3 class="widget-title text-uppercase text-center">Follow@Instagram</h3>

                    <div class="instragram-follow">
                        <a href="#">
                            <img src="assets/images/ins-flow.jpg" alt="">
                        </a>
                        <a href="#">
                            <img src="assets/images/ins-flow.jpg" alt="">
                        </a>
                        <a href="#">
                            <img src="assets/images/ins-flow.jpg" alt="">
                        </a>
                        <a href="#">
                            <img src="assets/images/ins-flow.jpg" alt="">
                        </a>
                        <a href="#">
                            <img src="assets/images/ins-flow.jpg" alt="">
                        </a>
                        <a href="#">
                            <img src="assets/images/ins-flow.jpg" alt="">
                        </a>
                        <a href="#">
                            <img src="assets/images/ins-flow.jpg" alt="">
                        </a>
                        <a href="#">
                            <img src="assets/images/ins-flow.jpg" alt="">
                        </a>
                        <a href="#">
                            <img src="assets/images/ins-flow.jpg" alt="">
                        </a>

                    </div>

                </aside>
            </div>
        </div>
    </div>
</div>