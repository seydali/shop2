<h2>Мои заказы:</h2>
<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
if(!empty($myOrder))
{
    $c=0;
    foreach($myOrder as $order)
    {
        $c++;
        ?>
        <h2>Заказ <?=$c?></h2>
        <div>
        <?php
        if($order->status==0){?>Статус: <strong>Обрабатывается</strong>


            <p id='productPrice'><?=$order->created_at?>  <div id='right'>
            <p >Дата оформления:</p>
            </div> <?php
        }
        if($order->status==1){?>Статус: <strong>Ожидает доставки</strong> <?php
        }
        if($order->status==2){?>Статус: <strong>Доставлен, ожидает получения</strong> <?php
        }
        if($order->status==3){?>Статус: <strong>Завершен/Закрыт</strong>
            <?php
        }?></div>
        <br><br>
        <?php
        for($i=0; $i<sizeof($order->prodInfo); $i++)
        {?><div>
            <?= HTML::img(Html::encode(str_replace('uploads', 'uploads/min/150', $order->product[$i]->image))) ?>
            <div id='productPrice'> Кол-во: (<?='<strong>'. $order->prodInfo[$i]->count
           .'</strong>)'?> </div>
            <br>
            <div id='productPrice'><strong>цена:</strong><?= $order->product[$i]->price ?></div>
            </div>
            <br> <br>
        <? } ?>


    <h4>Сумма: <?= $order->sum . ' руб.' ?></h4>
        <hr>
        <?php
        }



}
