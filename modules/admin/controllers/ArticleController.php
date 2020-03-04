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
        $categories = ArrayHelper::map(Category::find()->all(), 'id', 'name');
        $tags = ArrayHelper::map(Tag::find()->all(), 'id', 'name');

        if ($model->load(Yii::$app->request->post())){
            $model->saveArticle();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'categories' => $categories,
            'tags' => $tags
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
        $categories = ArrayHelper::map(Category::find()->all(), 'id', 'name');
        $currentCategory = $model->category_id;

        $tags = ArrayHelper::map(Tag::find()->all(), 'id', 'name');
        $tagIDs = $this->findModel($model->id)->getTags()->select('id')->asArray()->all();
        $currentTags = ArrayHelper::getColumn($tagIDs, 'id');

        if ($model->load(Yii::$app->request->post()) && $model->saveArticle()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'categories' => $categories,
            'currentCategory' => $currentCategory,

            'tags' => $tags,
            'currentTags' => $currentTags,
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

    public function actionSetImage($id)
    {
        $imageForm = new ImageUpload;
        $article = $this->findModel($id);

        if(Yii::$app->request->isPost)
        {
            $file = UploadedFile::getInstance($imageForm, 'imageFile');

            if($article->saveImage($imageForm->uploadImage($file, $article->image)))
            {

                return $this->redirect(['view', 'id' => $article->id]);

            }


        }
        return $this->render('image',
            ['model' => $imageForm]
        );

    }

    public function actionSetCategory($id)
    {
        $article = $this->findModel($id);
        $categories = ArrayHelper::map(Category::find()->all(), 'id', 'name'); # нужен array hel[per
        $currentCategory = ($article->category) ? $article->category->id : 0;
        if(Yii::$app->request->isPost)
        {

            $category_id = Yii::$app->request->post('category');

            if($article->saveCategory($category_id))
            {
                return $this->redirect(['view', 'id' => $article->id]);
            }
        }
        return $this->render('category',
            [
                'model' => $article,
                'categories' => $categories,
                'currentCategory' => $currentCategory
            ]);

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
