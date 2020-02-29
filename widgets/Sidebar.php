<?php


namespace app\widgets;

use app\models\Article;
use app\models\Category;
use yii\base\Widget;

class Sidebar extends Widget
{
    public function run()
    {
        $recent = Article::getRecent(4);
        $popular = Article::getPopular(3);
        $categories = Category::find()->all();

        return $this->render('/site/partials/sidebar',
            [
                'popular' => $popular,
                'recent' => $recent,
                'categories' => $categories,
            ]);
    }
}