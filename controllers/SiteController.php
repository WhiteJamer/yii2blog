<?php

namespace app\controllers;

use app\models\Article;
use app\models\CommentForm;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
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
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
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
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        # site/index

        $query = Article::find();
        $pagination = new Pagination(['totalCount' => $query->count(), 'defaultPageSize' => 3]);
        $articles = Article::find()
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        return $this->render('index',
            [
                'articles' => $articles,
                'pagination' => $pagination,
            ]);
    }

    public function actionArticles()
    {
        # site/articles

        $query = Article::find();
        $pagination = new Pagination(['totalCount' => $query->count(), 'defaultPageSize' => 5]);
        $articles = Article::find()
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        return $this->render('article-list',
            [
                'articles' => $articles,
                'pagination' => $pagination,
            ]);
    }

    public function actionArticle($id)
    {
        # Детальное представление статьи
        # site/article?id={$id}

        $article = Article::findOne(['id' => $id]);
        $commentForm = new CommentForm;

        return $this->render('single',
            [
                'article' => $article,
                'commentForm' => $commentForm,
            ]);
    }

    public function actionAddComment($article_id)
    {
        $commentForm = new CommentForm;
        if(Yii::$app->request->isPost)
        {
            $commentForm->load(Yii::$app->request->post());
            if($commentForm->addComment($article_id))
            {
                return $this->redirect(['site/article', 'id' => $article_id]);
            }
        }
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

        $model = new LoginForm();
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

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

}
