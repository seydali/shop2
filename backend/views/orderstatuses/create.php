<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\OrderStatuses */

$this->title = 'Create Order Statuses';
$this->params['breadcrumbs'][] = ['label' => 'Order Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-statuses-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
