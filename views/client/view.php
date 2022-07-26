<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Client */

$this->title = 'Account';
$this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name . ' ' . $model->surname . ' ' . $this->title;
?>
<div class="account-index">

	<h1><?= Html::encode($model->name) ?> <?= Html::encode($model->surname) ?> Account</h1>

	<p>
		<?= Html::a('Create Account', ['account/create'], ['class' => 'btn btn-success']) ?>
	</p>

	<?php // echo $this->render('_search', ['model' => $searchModel]); 
	?>


	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			'balance',
			'currency',
			'open_date',
			[
				'class' => ActionColumn::class,
				'urlCreator' => function ($action, $model, $key, $index, $column) {
					return Url::toRoute(["account/{$action}", 'id' => $model->id]);
				}
			],
		],
	]); ?>

</div>