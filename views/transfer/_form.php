<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Transfer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transfer-form">

	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'from_account_id')->dropDownList($array, ['prompt' => '']) ?>

	<?= $form->field($model, 'to_account_id')->dropDownList($array, ['prompt' => '']) ?>

	<?= $form->field($model, 'sum')->textInput(['maxlength' => true]) ?>

	<p style="color:red"><?= Html::encode($message) ?></p>

	<div class="form-group">
		<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>