<?php

use app\assets\TaggingAsset;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;
use yii\widgets\ActiveForm;

TaggingAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>
<?= $this->registerCssFile('/public/css/tag-basic-style.css', [
        'depends' => 'app\assets\TaggingAsset'
])?>
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

    <div data-tags-input-name="tag" id="tagBox"></div> <!-- Рендерит JS-поле для тегов -->

    <?= Html::dropDownList('tags', $currentTags, [], ['class' => 'form-control hidden', 'multiple' => true, 'name' => 'tags'])?>

    <?= $form->field($model, 'pub_date')->textInput() ?>
    <!-- Если у статьи уже есть картинка то она будет показываться в форме -->
    <?= ($model->image) ? Html::img($model->getImage(), ['width' => 100]) : null ?>
    <?= $form->field($imageModel, 'imageFile')->fileInput()?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>
<?php $currentTagsJS = JSON::encode($currentTags)  # Перекодируем переменную чтобы пользоваться ей в JS?>
<?= $this->registerJs(
        # Синтаксис Heredoc
        # Переменная хранящая в себе указанные в данный момент теги
        # Оъявляем переменную в теге HEAD чтобы можно было вызывать ее в JS-скриптах
<<<JS
    var currentTags = $currentTagsJS;
JS, View::POS_HEAD
);?>


<?php


?>
