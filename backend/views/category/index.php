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

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',        
            // названия-ссылки
            [
                'label' => 'Name',
                'format' => 'raw',
                'value' => function($dataProvider) {
                    return Html::a(
                        $dataProvider->name,
                        Url::to('view/'.$dataProvider->id)
                    );
                }
            ],  
            // названия родительских категорий       
            [
                'label' => 'Parent Category',
                'value' => function($dataProvider) {
                    return $dataProvider->parent_id ? Category::getCategoryName($dataProvider->parent_id) : '-';
                  //  return $dataProvider->parent_id;
                }
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Category $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
