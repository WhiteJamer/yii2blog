<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\HttpException;

class ErrorController extends Controller
{
    public function actionNotFound()
    {
        return $this->render('404');
    }

}