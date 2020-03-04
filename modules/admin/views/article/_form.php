<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>
    <?= Html::activeLabel($model, 'Категория'); ?>
    <?= Html::dropDownList('category', $currentCategory, $categories,
    [
            'class' => 'form-control',
            'prompt' => (!$currentCategory) ? 'Не указано...' : null,
    ]); ?>
    <?= Html::activeLabel($model, 'Теги'); ?>
    <?= Html::dropDownList('tags', $currentTags, $tags, ['class' => 'form-control', 'multiple' => true])?>

    <?= $form->field($model, 'pub_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php


?>
