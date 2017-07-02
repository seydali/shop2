<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Shares */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Shares', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shares-view">

    <h1><?= Html::encode($this->title) ?></h1>

   <?= "<div>".($model->iconimg->path?HTML::img(Html::encode($model->iconimg->path),['height'=>'200']):
        HTML::img(Html::encode('http://www.autostandart.com/graph/noimage.png'),['height'=>'40'])).
        "</div>
    <strong>ОПИСАНИЕ:</strong>
    <div>".$model->description."</div>
    <div><strong>Скидка:</strong>
    ".$model->discount."%</div>
             <div>   <strong>Длительность:</strong>
            ".$model->duration."</div>
    <strong>с:</strong>
    ".$model->created_at."
    <div>
    <br>

    </div>
    <br>" ?>
    <?php
    if(!empty($model->prodlist))
    {
        $ManSearch['onShare']='1';
        $ManSearch['selShares']=$model->title;
        echo HTML::a('<strong>ТОВАРЫ УЧАСТВУЮЩИЕ В АКЦИИ</strong>', \yii\helpers\Url::to(['products/index','ProductsSearch'=>$ManSearch])).'&nbsp;&nbsp;';

    }

    ?>

</div>
