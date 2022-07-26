<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Transaction */

$this->title = 'Create transaction';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transaction-create">

	<h1><?= Html::encode($this->title) ?></h1>

	<?= $this->render('_form', [
		'model' => $model,
		'array' => $array,
	]) ?>

</div>