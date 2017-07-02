<?php
use yii\helpers\Html;
use yii\helpers\Url;
if($success)
{?>
    <p>Ваш заказ успешно оформлен!</p>
        <div>Cтатус заказа можно отследить в <?=HTML::a('личном кабинете', ['#'])?></div>
<?php
}
if($address) {
 ?>
    <?= Html::beginForm(Url::to(['orders/confirm']), 'post'); ?>
    <div class="form-group">
        <?= Html::label('Подтвердите адрес доставки', 'FIELD-ID', ['class' => 'control-label']) ?>
        <?= Html::textarea($name = 'newAddress', $value = $address->address) ?>
        <div class="hint-block">Выберите значение</div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Подтвердить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php Html::endForm(); ?>
    <?php
}
?>

