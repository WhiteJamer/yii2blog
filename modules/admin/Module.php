<?php

namespace app\modules\admin;

use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\admin\controllers';
    public $layout = '/admin_layout';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'denyCallback' => function($role, $action)
                {
                    throw new NotFoundHttpException();
                },
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => function($role, $action)
                        {
                            return \Yii::$app->user->identity->isAdmin;
                        }
                    ]
                ]
            ]
        ];
    }
}
