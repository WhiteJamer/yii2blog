<?php

/* @var $this yii\web\View */

$this->title = $article->title . ' | ' . Yii::$app->name;

use app\widgets\Sidebar;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm; ?>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <article class="post">
                <div class="post-thumb">
                    <a href="<?= Url::toRoute(['site/article', 'id' => $article->id ]) ?>"><img src="<?= Html::encode($article->getImage()) ?>" alt=""></a>
                </div>
                <div class="post-content">
                    <header class="entry-header text-center text-uppercase">
                        <?php if($article->category): ?>
                            <h6><a href="<?= Url::toRoute(['site/category', 'id' => $article->category->id ]) ?>"><?= Html::encode($article->category->name) ?></a></h6>
                        <?php endif ?>

                        <h1 class="entry-title"><a href="<?= Url::toRoute(['site/article', 'id' => $article->id ]) ?>"><?= Html::encode($article->title) ?></a></h1>


                    </header>
                    <div class="entry-content">
                        <p><?= $article->content ?>
                        </p>
                    </div>
                    <div class="decoration">
                        <?php foreach($article->tags as $tag): ?>
                            <a href="#" class="btn btn-default"><?=Html::encode($tag->name)?></a>
                        <?php endforeach?>
                    </div>

                    <div class="social-share">
							<span
                                class="social-share-title pull-left text-capitalize">By <?= Html::encode($article->author->username) ?> On <?= Html::encode($article->getDate()) ?></span>
                        <ul class="text-center pull-right">
                            <li><a class="s-facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a class="s-twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a class="s-google-plus" href="#"><i class="fa fa-google-plus"></i></a></li>
                            <li><a class="s-linkedin" href="#"><i class="fa fa-linkedin"></i></a></li>
                            <li><a class="s-instagram" href="#"><i class="fa fa-instagram"></i></a></li>
                        </ul>
                    </div>
                </div>
            </article>
            <h4>Comments (<?= Html::encode($article->getComments()->count()) ?>)</h4>
            <?php foreach ($article->comments as $comment): ?>
                <div class="bottom-comment"><!--bottom comment-->

                    <div class="comment-img">
                        <?php
                        $options = [
                                'style' => ['width' => '7rem', 'height' => '7rem'],
                                'class' => ['img-circle']
                                ];
                        ?>

                        <?= Html::img($comment->author->getAvatar(), $options); ?>
<!--                        <img class="img-circle" src="--><?//= Html::encode($comment->author->getAvatar()) ?><!--" alt="">-->
                    </div>

                    <div class="comment-text">
                        <a href="#" class="replay btn pull-right"> Replay</a>
                        <h5><?= Html::encode($comment->author->username) ?></h5>

                        <p class="comment-date">
                            <?= Html::encode($comment->pub_date) ?>
                        </p>


                        <p class="para"><?= Html::encode($comment->body) ?></p>
                    </div>
                </div>
            <?php endforeach ?>
            <!-- end bottom comment-->


            <?php if (!Yii::$app->user->isGuest): ?>
                <div class="leave-comment"><!--leave comment-->
                <h4>Leave a reply</h4>
                <?php $form = ActiveForm::begin([
                            'action' => ['/site/add-comment', 'article_id' => $article->id],
                        ]) ?>
                    <?= $form->field($commentForm, 'body')->textarea(['class' => 'form-control'])->label(false) ?>
                    <?= Html::submitButton('Leave comment', ['class' => 'btn btn-success'])?>
                <?php ActiveForm::end() ?>
            </div><!--end leave comment-->
            <?php else: ?>
                <h4>Вы не авторизованы. <a href="<?= Url::toRoute('site/login')?>">Войдите</a>, чтобы оставлять комментарии</h4>
            <?php endif ?>
        </div>
        <?= Sidebar::widget() ?>
    </div>
</div>