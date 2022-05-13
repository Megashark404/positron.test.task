<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use common\models\Book;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Books';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Book', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'isbn',
                'format' => 'raw',
                'value' => function($dataProvider) {
                    return Html::a(
                        $dataProvider->isbn,
                        Url::to('view/'.$dataProvider->isbn)
                    );
                }
            ],
            'title',

            //'authors',
            //'thumbnail_url:url',
            'short_description:ntext',
            //'long_description:ntext',
          
            

            'page_count',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Book $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'isbn' => $model->isbn]);
                 }
            ],
        ],
    ]); ?>


</div>
