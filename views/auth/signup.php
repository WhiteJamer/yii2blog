<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Регистрация | ' . Yii::$app->name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup container">
        <h1>Регистрация</h1>

        <p>Пожалуйста заполните данные поля чтобы зарегистрироваться::</p>

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Имя пользователя') ?>

        <?= $form->field($model, 'email')->textInput()->label('Электронная почта') ?>

        <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>


        <div class="form-group">
            <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>

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
