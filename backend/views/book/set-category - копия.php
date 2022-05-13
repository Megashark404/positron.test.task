<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Book */
/* @var $form yii\widgets\ActiveForm */
?>
<h5>Set category</h5>

<div class="book-form">

    <?= Html::beginForm(['/book/set-category/'.$model->isbn], 'post') ?>
         <div >
            <label for="category" class="form-label">Category</label>
            <input class="mb-3" type="text" class="form-control" name="category" id="category">        
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    <?= Html::endForm() ?>


   

</div>
