<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Войти | ' . Yii::$app->name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login container">
    <div class="row">
        <div class="col-md-10">
            <h1>Войти</h1>

            <p>Пожалуйста заполните данные поля чтобы авторизоваться:</p>

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-1 control-label'],
                ],
            ]); ?>

            <?php if($model->scenario === 'loginWithEmail'): ?>
                <?= $form->field($model, 'email')->textInput(['autofocus' => true])->label('Электронная почта') ?>
            <?php else:?>
                <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Имя пользователя') ?>
            <?php endif ?>

            <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>

            <?= $form->field($model, 'rememberMe')->checkbox([
                'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
            ])->label('Запомнить меня?') ?>

            <div class="form-group">
                <div class="col-lg-offset-1 col-lg-11">
                    <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
        <div class="col-md-2">
            <script type="text/javascript" src="https://vk.com/js/api/openapi.js?167"></script>
            <script type="text/javascript">
                VK.init({apiId: 7341545});
            </script>

            <!-- VK Widget -->
            <div id="vk_auth"></div>
            <script type="text/javascript">
                VK.Widgets.Auth("vk_auth", {"authUrl":"/auth/vk-auth/"});
            </script>
        </div>
    </div>

</div>
