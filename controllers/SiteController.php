<?php

namespace app\controllers;

use app\models\Article;
use app\models\Category;
use app\models\CommentForm;
use app\models\SignupForm;
use app\models\Tag;
use app\models\User;
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
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        # site/index

        $query = Article::find();
        $pagination = new Pagination(['totalCount' => $query->count(), 'defaultPageSize' => 3]);
        $articles = $query
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
        $articles = $query
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        return $this->render('article-list',
            [
                'articles' => $articles,
                'pagination' => $pagination,
            ]);
    }

    public function actionCategory($id)
    {
        # site/articles
        $category = Category::findOne(['id' => $id]);
        $query = Article::find()
            ->where(['category_id' => $id]);
        $pagination = new Pagination(['totalCount' => $query->count(), 'defaultPageSize' => 5]);
        $articles = $query
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        return $this->render('category',
            [
                'articles' => $articles,
                'pagination' => $pagination,
                'category' => $category,
            ]);
    }

    public function actionTag($name)
    {
        $tag = Tag::findOne(['name' => $name]);
        $query = $tag->hasMany(Article::className(), ['id' => 'article_id'])
            ->viaTable('article_tag', ['tag_id' => 'id']);
        $pagination = new Pagination(['totalCount' => $query->count(), 'defaultPageSize' => 5]);
        $articles = $query
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        return $this->render('tag',
            [
                'tag' => $tag,
                'articles' => $articles,
                'pagination' => $pagination
            ]);
    }

    public function actionArticle($id)
    {
        # Детальное представление статьи
        # site/article?id={$id}

        $article = Article::findOne(['id' => $id]);
        $article->viewCounter(); # Инкрементация счетчика просмотров
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
