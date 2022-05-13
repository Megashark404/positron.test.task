<?php

/** @var \yii\web\View $this */
/** @var string $content */

use backend\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;



AppAsset::register($this);
?>

<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <?php $this->head() ?>
</head>
<body class="">

<?php $this->beginBody() ?>

<div class="wrap h-100 d-flex flex-column">  
    <div class="wrap h-100 d-flex flex-column">  
        <?php echo $this->render('_header') ?>    
        <?php echo $content ?>
    </div>
   
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();
