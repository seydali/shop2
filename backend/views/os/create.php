<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Os */

$this->title = 'Create Os';
$this->params['breadcrumbs'][] = ['label' => 'Ос', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="os-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
