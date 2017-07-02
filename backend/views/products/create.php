<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model common\models\Products */

$this->title = 'Созать продукт';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-create">

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
