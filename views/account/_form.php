<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Account */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="account-form">

	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'balance')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'currency')->dropDownList(['BYN' => 'BYN', 'USD' => 'USD', 'EUR' => 'EUR',], ['prompt' => '']) ?>

	<?= $form->field($model, 'open_date')->textInput() ?>

	<?= $form->field($model, 'client_id')->textInput() ?>

	<div class="form-group">
		<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>