<?php

//var_dump(Yii::$app->session);
use yii\helpers\Html;
use yii\widgets\Pjax;

//var_dump($products['items'][0]['count']);
//die(var_dump($products));
if (!empty($products))
if (!empty($products['prod']))
{ ?>
<div class="col-md-10 col-sm-4"><?
    Pjax::begin(['enablePushState' => false, 'id' => 'basket_list']);
    //for( $i=0;$i<sizeof($products['prod']); $i++)
    foreach ($products['prod'] as $prod)
    {
    ?>
    <div>
        <div><?= Html::a(Html::encode($prod->pInfo->name), ['/products/view', 'id' => $prod->id]) ?></div>

        <div class='productDelwraper'>
            <?= HTML::a('<img src="http://s1.iconbird.com/ico/2013/10/464/w128h1281380984637delete13.png" height="20" width="20">',
                '#', ['class' => 'productDel', 'title' => "УДАЛИТЬ", 'productId' => $prod->id]) ?>
        </div>


        <div>
            <?= HTML::img(Html::encode(str_replace('uploads', 'uploads/min/150', $prod->pInfo->image))) ?>
        </div>

        <div id='productCount'>
            <div> Кол-во:
                <?= '<strong>' . HTML::a(' - ', '#', ['class' => 'countMinus', 'id' => 'pjaxMinus', 'act' => 'sub', 'productId' => $prod->id]) .
                $prod->count .
                HTML::a(' + ', '#', ['class' => 'countPlus', 'id' => 'pjaxPlus', 'act' => 'add', 'productId' => $prod->id]) . '</strong>' .
                "</div></div><br>" ?>
                <div id='productPrice'><h3><strong><?= $prod->pInfo->price ?></strong></h3></div>

            </div>
            <br><br>
            <? } ?>


            <h4>Сумма: <?= $products["itog"]['sum'] . ' руб.' ?></h4>
            <div><?= HTML::a('ОФОРМИТЬ ЗАКАЗ', ['orders/registration'], ['class' => 'checkout']) ?></div>
            <?php Pjax::end();

            $this->registerJsFile('/js/basketWork.js', ['position' => yii\web\View::POS_END, 'depends' => [\yii\web\JqueryAsset::className()]]);
            ?> </div><?php
        }
        else { ?>
            <h2>Корзина пуста</h2>
        <?
        }
        ?>

