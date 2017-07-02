<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model common\models\Products */

$this->title = 'Редактировать продукты: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Продукты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="products-update">

   <?php Pjax::begin(['enablePushState' => false]);?>

    <?= $this->render('_form', [
        'model' => $model,
        'prodLinks'=>$prodLinks,
        'cats'=>$cats,
        'manLinks'=>$manLinks,
        'mans'=>$mans,
        'osLinks'=>$osLinks,
        'os'=>$os,
       'prodLinksNew'=>$prodLinksNew,
    ]) ?>


    <?php
        Pjax::end();
    ?>

</div>
