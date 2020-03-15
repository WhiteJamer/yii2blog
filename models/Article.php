<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $content
 * @property int|null $author_id
 * @property int|null $category_id
 * @property string|null $pub_date
 * @property int|null $views
 * @property string|null $image
 *
 * @property User $author
 * @property Category $category
 * @property ArticleTag[] $articleTags
 * @property Tag[] $tags
 * @property Comment[] $comments
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 255],
            [['content', 'image'], 'string'],
            [['title', 'content'], 'required'],
            [['author_id', 'category_id', 'views'], 'integer'],
            [['pub_date'], 'default', 'value' => date('Y-m-d H:i:s')],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'content' => 'Контент',
            'author_id' => 'Автор',
            'category_id' => 'Категория',
            'pub_date' => 'Дата публикации',
            'views' => 'Просмотры',
            'image' => 'Картинка',
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[ArticleTags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticleTags()
    {
        return $this->hasMany(ArticleTag::className(), ['article_id' => 'id']);
    }

    /**
     * Gets query for [[Tags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])->viaTable('article_tag', ['article_id' => 'id']);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['article_id' => 'id']);
    }

    public function saveImage($filename)
    {
        $this->image = $filename;
        return ($this->save(false)) ? true : false;
    }

    public function deleteCurrentImage()
    {
        $imageUploadModel = new ImageUpload;
        $imageUploadModel->deleteCurrentImage($this->image);
        $this->image = null;
    }

    public function setCategory($name)
    {
        $category = Category::findOne(['name' => $name]); # Проверяем есть ли статья с данным именем в базе

        if($category) # Если категория уже есть в базе,
        {
            $this->category_id = $category->id; # то просто задаем статье ее id
            return $this->save(); # и обновляем статью
        }
        else{ # Если такой категори не существует то создаем ее
            $newCategory = new Category;
            $newCategory->name = $name;
            $newCategory->save(); # Сохраняем созданную статью в базе

            $this->category_id = $newCategory->id; # Задаем статье id выбранной категории
            return $this->save(); # и обновляем статью
        }
    }

    public function setTags($tags)
    {
        $this->clearCurrentTags(); # Удаляем старые связи из промежуточной таблицы ArticleTag
        if($tags) # возможность оставить поле тегов пустым
        {
            foreach ($tags as $tag_id) # Перебираем массив тегов и связываем каждый тег с указанной статьей.
            {

                $tag = Tag::findOne(['id' => $tag_id]);
                $this->link('tags', $tag);
                $this->save(false);
            }
        }
        return true;
    }

    public function clearCurrentTags()
    {
        if($this->tags != null)
        {
            return ArticleTag::deleteAll(['article_id' => $this->id]);
        }
    }

    public function getImage()
    {
        return ($this->image) ? '/uploads/' . $this->image : '/no-image.png';
    }

    public function getDate()
    {
        return Yii::$app->formatter->asDate($this->pub_date);
    }

    public static function getPopular($limit = 5)
    {
        return static::find()->orderBy('views desc')->limit($limit)->all();
    }

    public static function getRecent($limit = 5)
    {
        return static::find()->orderBy('pub_date desc')->limit($limit)->all();
    }

    public function saveArticle()
    {
        if ($this->author_id === null)
        {
            $this->author_id = Yii::$app->user->id;
        }
        $this->save();
        $this->setTags(Yii::$app->request->post('tags'));
        $this->setCategory(Yii::$app->request->post('category'));
    }

    public function viewCounter()
    {
        $this->views++;
        return $this->save();
    }
    public function beforeDelete()
    {
        $this->deleteCurrentImage(); # Удаляет картинку с сервера, до удаления записи из базы
        return parent::beforeDelete(); // TODO: Change the autogenerated stub
    }
}
