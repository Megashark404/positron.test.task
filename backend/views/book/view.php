<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Book */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="book-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="book-view-actions">
        <?= Html::a('Update', ['update', 'isbn' => $model->isbn], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Set category', ['set-category', 'isbn' => $model->isbn], ['class' => 'btn btn-secondary']) ?>
        <?= Html::a('Delete', ['delete', 'isbn' => $model->isbn], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <div class="book-thumbnail m-2">
        <img src="<?= $model->thumbnail_url?>" alt="">
    </div>

    <?php 
    // формируем массив категорий, который будем показывать в соответствующем поле
    foreach ($model->categories as $category) {
        $categories[] = $category->name;
    }

    ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'isbn',
            'title',
            'short_description:ntext',
            'long_description:ntext',
            [
                'label' => 'Status',
                'value' => $model->getStatusLabels()[$model->status]
            ],
            'authors',
            'page_count',
            [
                'label' => 'Categories',
                'value' => (isset($categories)) ? implode(', ', $categories) : ''
            ]
           
        ],
    ]) ?>


   

</div>
