<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use common\models\Category;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="category-index">

    <h2><?= Html::encode($this->title).': '.$categoryName ?></h2>

    <div class="categories">
        <h5>Categories</h5>
        <?php foreach ($categories as $category): ?>
            <div class="category"><?= Html::a($category->name, ['category/front/'.$category->id]) ?></div>            
        <?php endforeach; ?>  
    </div>

    <div class="books">
        <h5>Books:</h5>
        <?php //var_dump($books);die; ?>
        <?php foreach ($books as $book): ?>
            <div class="book"><?= Html::a($book->title, ['/book/view/'.$book->isbn]) ?></div>            
        <?php endforeach; ?>  
    </div>

</div>
