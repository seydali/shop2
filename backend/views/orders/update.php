<?php

use yii\helpers\Html;

use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model common\models\Orders */
/* @var $orders common\models\Orders */

$this->title = 'Редактировать заказы: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="orders-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'orders' => $orders,
        'link'=>$link,
        'allProd'=>$allProd,
           'stats'=>$stats,
    ]) ?>

</div>
<?php \yii\widgets\Pjax::begin(['enablePushState' => false]); ?>
<?php
for($i=0; $i<sizeof($orders->prodInfo); $i++){
    //foreach( $prodInfo->product as $prod){var_dump($prod);?>
    <div class='productDelwraper'>
        <?= HTML::a('<img src="http://s1.iconbird.com/ico/2013/10/464/w128h1281380984637delete13.png" height="20" width="20">',
            ['orders/dellink','sign'=>'minus', 'prodId' => $orders->product[$i]->id,  'orderId' => $model->id]) ?>
    </div>
    <p><strong>Товар №<?=$x=$i-1?></strong>

          <strong>, кол-во:</strong> <?= HTML::a('-',
            ['orders/changecount', 'sign'=>'minus','prodId' => $orders->product[$i]->id,  'orderId' => $model->id]) ?>
                    (<?=$orders->prodInfo[$i]->count?>)
        <?= HTML::a('+',
            ['orders/changecount', 'sign'=>'plus', 'prodId' => $orders->product[$i]->id,  'orderId' => $model->id]) ?>
    </p>
    <div class="orders-view">

        <?=Html::a(Html::encode($orders->product[$i]->name), ['products/view', 'id' => $orders->product[$i]->id]).
        '<strong><p> ЦЕНА:'.$orders->prodInfo[$i]->price.'</p></strong>'?>
    </div>

    <?php
}
\yii\widgets\Pjax::end();

Modal::begin([
    'header'=>'<h4>Добавление товара</h4>',
    'toggleButton'=>['label'=>'Добавить товар',
        'tag'=>'button',
        'class'=>'btn btn-danger'  ],

]);


$form = ActiveForm::begin(['id' => 'contact-form',]);
//$form->action='orders/addnewprod';
$items = ArrayHelper::map($allProd,'id','name');
$params = [
    'prompt' => 'Выберите Продукт'
];?>
<?= $form->field($link, 'id_product')->dropDownList($items,$params)?>
<?= $form->field($link, 'count')->textInput() ?>
<?=$form->field($link, 'actionfield')->hiddenInput(['value'=>'addproduct'])->label(false)?>

<?php
echo Html::submitButton( 'Добавить',
    ['class' => $link->isNewRecord ? 'btn btn-success' : 'btn btn-primary']);
ActiveForm::end();

Modal::end();

?>
