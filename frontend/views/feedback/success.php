<?php

use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model common\models\Feedback */

$this->title = 'Сообщение отправлено';
$this->params['breadcrumbs'][] = '';

?>

<div class="feedback-success">

    <h1 class="mb-4"><?= Html::encode($this->title) ?></h1>

    <p>
        Ваше сообщение успешно отправлено! С вами свяжутся по оставленным координатам
    </p>

    <?= Html::a('Вернуться на главную страницу', Url::to('/index'))?>    

</div>
