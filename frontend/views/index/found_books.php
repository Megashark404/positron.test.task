<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Found books: ';

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1 class="mb-5"><?= Html::encode($this->title) ?></h1> 

     <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        /*'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);*/
        'itemView' => '_book_item',
        'layout' => '<h4>Books:</h4><div class="d-flex flex-wrap">{items}</div>{pager}',
        'itemOptions' => [
            'tag' => false
        ],
        
    ]) ?>


</div>

