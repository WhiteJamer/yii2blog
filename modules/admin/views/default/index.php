<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Article */

$this->title = 'AdminBar | ' . Yii::$app->name;
?>

<h1 class="text-center">Admin-bar</h1>
<div class="row justify-content-center">
    <div class="col-md text-center mt-5">
        <div class="row mt-1"><a href="/admin/article" class="btn btn-primary form-control">Articles</a></div>
        <div class="row mt-1"><a href="/admin/category" class="btn btn-primary form-control">Categories</a></div>
        <div class="row mt-1"><a href="/admin/tag" class="btn btn-primary form-control">Tags</a></div>
    </div>
</div>
