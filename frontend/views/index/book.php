<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Book: '.$model->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
<div class="book-detail">

    <h1 class="mb-3"><?= Html::encode($this->title) ?></h1> 
    <div class="row ">
        <div class="col-lg-2 col-md-3 col-sm">
             <img src="<?= Yii::$app->params['backendUrl'].$model->thumbnail_url?>" alt="">
        </div>
        <div class="col-lg-4 col-sm p-0">    
            <div>Auhors: <?= $model->authors ?></div>       
            <div>ISBN: <?= $model->isbn ?></div>
            <div>Pages: <?= $model->page_count ?></div>
            <div class="book-categories mt-3">
                Categories: 
                <?php foreach ($model->categories as $category): ?>
                    <p class="m-0"><?= Html::a($category->name, Url::to('/index/category/'.$category->id)) ?></p>
                <?php endforeach ?>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col">
            <div class="book-description">
                <b>Description:</b><br>
                <?= $model->long_description ?>
            </div>
        </div>
    </div>

   
   
   

    
    


</div>

</div>