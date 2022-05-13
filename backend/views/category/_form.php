<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $form yii\widgets\ActiveForm */


/*$categories = [
	'open source',
	'programming' => ['java', 'php', 'c++'],
	'computer science',
	'data science'
];*/

?>
<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'parent_id')->dropdownList(
    	ArrayHelper::map($allCategories, 'id', 'name'),
    	['options' => [$model->id => ['disabled' => true]]] // текущую категорию делаем недоступной для выбора в качестве родительской
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
