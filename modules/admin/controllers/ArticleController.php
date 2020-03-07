<?php

namespace app\modules\admin\controllers;

use app\models\ArticleTag;
use app\models\Category;
use app\models\ImageUpload;
use app\models\Tag;
use Yii;
use app\models\Article;
use app\models\ArticleSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Article model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Article();
        $imageForm = new ImageUpload;

        $categories = ArrayHelper::map(Category::find()->all(), 'id', 'name');
        $tags = ArrayHelper::map(Tag::find()->all(), 'id', 'name');

        if ($model->load(Yii::$app->request->post()) && $imageForm->load(Yii::$app->request->post()))
        {
            $model->saveArticle(); # Создаем статью и задаем ей категорию и теги
            $this->setImage($model);  # Затем устанавливаем для нее картинку

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'categories' => $categories,
            'tags' => $tags,
            'imageModel' => $imageForm
        ]);
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

        $model = $this->findModel($id);
        $imageForm = new ImageUpload;

        $categories = ArrayHelper::map(Category::find()->all(), 'id', 'name');
        $currentCategory = $model->category_id;

        $names = $model->getTags()->asArray()->select('name')->all();
        $currentTags = ArrayHelper::getColumn($names, 'name');

        if ($model->load(Yii::$app->request->post()) && $imageForm->load(Yii::$app->request->post()))
        {
            $model->saveArticle(); # Обновляем данные о статье + категорию и теги
            $this->setImage($model); # Обновляем картинку

            $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'categories' => $categories,
            'currentCategory' => $currentCategory,

            'tags' => $tags,
            'currentTags' => $currentTags,
            'imageModel' => $imageForm,
        ]);
    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function setImage(Article $articleForm)
    {
        $imageForm = new ImageUpload;
        $article = $this->findModel($articleForm->id);

        $file = UploadedFile::getInstance($imageForm, 'imageFile');

        if($file) # Загрузка картинки будет только если поле imageFile не пустое.
        {
            $article->saveImage($imageForm->uploadImage($file, $article->image));
        }
        return true;
    }

    public function actionSendTags()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(Yii::$app->request->isAjax)
        {
            $tags = array(); # В этот массив нужно поместить ключи тегов для передачи их в поле 'tags' в ArticleForm.
            $tagNames = Yii::$app->request->post('data'); # Массив имен из JS-виджета для удобного задания тегов.
            foreach ($tagNames as $name)
            {
                $tag = Tag::findOne(['name' => $name]);
                if($tag) # Если тег существует то выбираем из него ID
                {
                    array_push($tags, $tag->id); # Добавляем ID тега в массив.
                }
                else{ # Если такого тега не существует, то создаем его
                    $new_tag = new Tag;
                    $new_tag->name = $name;
                    $new_tag->save();
                    array_push($tags, $new_tag->id);
                }
            }
            $tags = array_unique($tags, SORT_REGULAR); # Убираем дубликаты из массива, если вдруг они возникнут.
            return $tags;
//            return 'Все ок';
        }
    }

    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
