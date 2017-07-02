<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Os */

$this->title = 'Редактировать Ос: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Ос', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="os-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
