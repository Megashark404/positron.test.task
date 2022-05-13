<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1> 
    
    <!-- форма поиска -->
    <nav class="navbar navbar-light bg-light">
      <div class="container-fluid">
        <form class="d-flex" action="<?= Url::to('/index/search')?>" method="get">
          <input class="form-control me-2 mr-2" type="search" placeholder="Book title" name="search-title">
          <input class="form-control me-2 mr-2" type="search" placeholder="Authors" name="search-authors">          
          <select class="form-control me-2 mr-2" name="search-status" >
              <option value="">-</option>
              <option value="1">Published</option>
              <option value="0">Unpublished</option>             
          </select>
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </nav>


    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        /*'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);*/
        'itemView' => '_category_item',
        'layout' => '<div class="d-flex flex-wrap">{items}</div>{pager}',
        'itemOptions' => [
            'tag' => false
        ],
        
    ]) ?>


</div>

