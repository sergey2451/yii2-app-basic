<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Account */

$this->title = 'Create Account';
$this->params['breadcrumbs'][] = ['label' => 'Clients', 'url' => ['client/index']];
$this->params['breadcrumbs'][] = ['label' => $str, 'url' => ['client/view', 'id' => $model->client_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
