<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Video */

$this->title = 'Create Video';
$this->params['breadcrumbs'][] = ['label' => 'Videos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-create">

    <h1><?= Html::encode($this->title) ?></h1>

   <div class="d-flex flex-column justify-content-center align-items-center">
   	<br>
   <div class="upload-icon">
   		<i class="fas fa-upload"></i>
   </div> 
   	<p class="m-0">Drag and drop your file</p>
   	<p class="muted">Your video will be private until you pubish it</p>

   	<?php ActiveForm::begin([
   		'options' => ['enctype' => 'multipart/form-data']
   	]) ?>

   	<button class="btn btn-primary btn-file">
   		select file
   		<input type="file" id="videoFile" name="video">
   	</button>

   	<?php ActiveForm::end() ?>

   </div>

</div>
