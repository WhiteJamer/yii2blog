<?php


namespace app\controllers;


use app\models\LoginForm;
use app\models\SignupForm;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class AuthController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get','post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $loginWithEmail = Yii::$app->params['loginWithEmail'];
        $model = $loginWithEmail ? new LoginForm(['scenario' => 'loginWithEmail']) : new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionSignup()
    {
        $model = new SignupForm;
        if(Yii::$app->request->isPost)
        {
            if($model->load(Yii::$app->request->post()) and $model->signUp())
            {
                $user = User::findByUsername($model->username);
                Yii::$app->user->login($user);
                return $this->redirect(['index']);
            }
        }
        return $this->render('signup',
            [
                'model' => $model
            ]);
    }

    public function actionVkAuth($uid, $first_name, $photo)
    {
        $user = User::findOne(['vk_id' => $uid]);
        if(!$user)
        {
            $user = new User;
            $user->vk_id = $uid;
            $user->username = $first_name;
            $user->avatar = $photo;

            die('ЗАРЕГАН');
            $user->save();
        }
        else
        {
            Yii::$app->user->login($user);
            return $this->goBack();
        }

    }
}