<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Category;

?>


<div class="card m-3" style="width: 14rem;">
  <div class="card-body">  
    <h5 class="card-title"><?= Html::a($model->name, Url::to('/index/category/'.$model->id)) ?></h5>
    <p class="card-text">    	 
		Вложенных категорий: <?= count(Category::find()->where(['parent_id' => $model->id])->all())?><br>
		Книг в категории: <?= count($model->books) ?>
    </p>
   
  </div>
</div>

