<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $book common\models\Book */
/* @var $form yii\widgets\ActiveForm */
?>
<h5 class="mb-4">Set category for book "<?= $book->title?>"</h5>

<div class="book-form">	

    <?= Html::beginForm(['/book/set-category/'.$book->isbn], 'post') ?>
         <div >           
        
        	<?php foreach ($allCategories as $category): ?>
        		<?= Html::checkbox('category[]', in_array($category['id'], $currentCategories) ? true : false , ['label' => $category['name'], 'value' => $category['id']]) ?>
                <br>
        		
        	<?php endforeach ?>        	
        	
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    <?= Html::endForm() ?>


   

</div>
