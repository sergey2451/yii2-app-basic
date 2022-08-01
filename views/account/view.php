<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumnTransaction;
use yii\grid\GridView;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Account */

$this->title = $model->id;
\yii\web\YiiAsset::register($this);
?>

<div class="account-view">

	<p>
		<?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
		<?= Html::a('Delete', ['delete', 'id' => $model->id], [
			'class' => 'btn btn-danger',
			'data' => [
				'confirm' => 'Are you sure you want to delete this item?',
				'method' => 'post',
			],
		]) ?>
	</p>

	<?= DetailView::widget([
		'model' => $model,
		'attributes' => [
			'balance',
			'currency',
		],
	]) ?>

</div>

<div class="transaction-index">

	<h1>Transactions</h1>

	<?php // echo $this->render('_search', ['model' => $searchModel]); 
	?>

	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			'dt',
			'sum',
			[
				'class' => ActionColumnTransaction::class,
				'urlCreator' => function ($action, $model, $key, $index, $column) {
					return Url::toRoute(["transaction/{$action}", 'id' => $model->id]);
				}
			],
		],
	]); ?>

</div>