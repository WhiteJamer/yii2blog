<?php

use app\assets\AjaxSearchAsset;
use app\assets\TaggingAsset;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;
use yii\widgets\ActiveForm;

TaggingAsset::register($this);
AjaxSearchAsset::register($this);

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
    <div class="category-input">
        <?= Html::textInput('category', $currentCategory, ['id' => 'categoryAjaxInput', 'class' => 'form-control', 'autocomplete' => 'off']); ?>
        <div class="myDropDown" id="categoryAjaxResults" style="display:none">
        <?= $this->registerCss('
        .myDropDown{
        min-height: 0;
        z-index: 2;
        position: absolute;
        background: #fff;
        border: 0.1rem solid #000;
        width: 100%;
        padding: 0.5rem;
        color: green;
        list-style: none;
        }
        li.selected{
        background: #eee;
        }
        .category-input{
        position: relative;
        }
        ')?>
    </div>
    </div>
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
