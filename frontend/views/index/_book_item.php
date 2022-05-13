<?php 

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Category;


?>


<div class="card m-3" style="width: 14rem;">
  <div class="card-body"> 
  	<img src="<?= Url::to(Yii::$app->params['backendUrl'].$model->thumbnail_url) ?>" alt="">
    <h5 class="card-title"><?= Html::a($model->title, Url::to('/index/book/'.$model->isbn)) ?></h5>
    <p class="card-text">    	 
		<small class=""><?= $model->authors ?></small><br>
		<small class="text-muted">ISBN: <?= $model->isbn ?></small>
		
    </p>
   
  </div>
</div>

