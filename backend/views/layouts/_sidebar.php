<aside class="shadow">

<?php 
echo \yii\bootstrap4\Nav::widget([
	'options' => [
		'class' => 'd-flex flex-column nav-pills'
	],
	'items' => [
		[
			'label' => 'Books',
			'url' => ['/book/index']
		],
		[
			'label' => 'Categories',
			'url' => ['/category/index']
		],
		
	]
]);
?>

</aside>