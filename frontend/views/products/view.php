<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\i18n\Formatter;
use yii\widgets\Pjax;
use kartik\rating\StarRating;
use common\widgets\CollFiltration;

/* @var $this yii\web\View */
/* @var $model common\models\Products */

$this->title = $model->name;
$ProductsSearch['categories'] = $model->category->name;
$this->params['breadcrumbs'][] = ['label' => 'Каталог', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->category->name, 'url' => ['index', 'ProductsSearch' => $ProductsSearch]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="products-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="col-md-12 col-sm-4">
        <?php
        echo newerton\fancybox\FancyBox::widget([
            'target' => 'a[rel=fancybox]',
            'helpers' => true,
            'mouse' => true,
            'config' => [
                'maxWidth' => '90%',
                'maxHeight' => '90%',
                'playSpeed' => 7000,
                'padding' => 0,
                'fitToView' => false,
                'width' => '70%',
                'height' => '70%',
                'autoSize' => false,
                'closeClick' => false,
                'openEffect' => 'elastic',
                'closeEffect' => 'elastic',
                'prevEffect' => 'elastic',
                'nextEffect' => 'elastic',
                'closeBtn' => false,
                'openOpacity' => true,
                'helpers' => [
                    'title' => ['type' => 'float'],
                    'buttons' => [],
                    'thumbs' => ['width' => 68, 'height' => 50],
                    'overlay' => [
                        'css' => [
                            'background' => 'rgba(0, 0, 0, 0.8)'
                        ]
                    ]
                ],
            ]
        ]);


        ?>
        <? foreach ($model->images as $image) {
            echo Html::a(Html::img(str_replace('uploads', 'uploads/min/150/', $image->path)), $image->path, ['rel' => 'fancybox']);
            //echo "<img src=".str_replace('uploads', 'uploads/min/150/',$image->path).">";
        } ?>
        <div id="right"><h2 id='productViewPrice'><?= $model->price; ?> руб.</h2></div>
        <?php

        echo '<br><label class="control-label">РЕЙТИНГ</label>';
        if (!empty(Yii::$app->user->id)) {
            echo StarRating::widget(['model' => $model, 'attribute' => 'rating',
                'pluginOptions' => [
                    'theme' => 'krajee-uni',
                    'filledStar' => '&#x2605;',
                    'emptyStar' => '&#x2606;'

                ]
            ]);
            $js = <<< JS

        $(document).ready(function () {
            $('#products-rating').on('rating.change', function(event, value, caption) {
                console.log(value);
               // location.href = 'http://www.yandex.ru/';

                     $.post("?r=products/setrating&rating="+(value)+"&prod={{prodID}}");



            });
        });
JS;
            $js = str_replace('{{prodID}}', $model->id, $js);
            $this->registerJs($js);
        }

        Pjax::begin(['enablePushState' => false]); ?>
        <?= "<div id='productBuy'>" .
        HTML::a('В КОРЗИНУ', '#', ['class' => 'productBuy', 'id' => 'pjaxBuy', 'productId' => $model->id]) .
        "</div>"; ?>
        <div class="number">
            <a href="#" class="minus">-</a>
            <input type="text" name="counter" id="counter<?= $model->id ?>" value="1" size="1"/>
            <a href="#" class="plus">+</a>
        </div>
        <?php Pjax::end(); ?>
    </div>
    <h3>Рекомендуемые товары</h3>
    <br>
    <?= CollFiltration::widget() ?>
    <div class="col-md-3 col-sm-4">
        <strong>Поддерживаемые ОС:</strong><br>
        <? foreach ($model->oslist as $os) {
            $OsSearch['os'] = $os->name;
            echo HTML::a($os->name, \yii\helpers\Url::to(['index', 'ProductsSearch' => $OsSearch])) . '&nbsp;&nbsp;';
        }; ?>
        <br>
        <strong>Производитель:</strong><br>
        <? foreach ($model->manlist as $man) {
            $ManSearch['manufacturers'] = $man->name;
            echo HTML::a($man->name, \yii\helpers\Url::to(['index', 'ProductsSearch' => $ManSearch])) . '&nbsp;&nbsp;';
        }; ?>
        <? //var_dump($model->shares[0]);
        if (!empty($model->shares) && $model->shares != NULL) {
            ?>
            <h3>Товар участвует в акции: </h3>
            <?= HTML::a($model->shares[0]->title, \yii\helpers\Url::to(['shares/view', 'id' => $model->shares[0]->id])) ?>
        <?
        }
        ?>
    </div>
    <div class="col-md-8 col-sm-4">
        <h1>Описание:</h1>
        <div><?= $model->description; ?></div>
        <h1>Системные требования:</h1>
        <div><?= $model->system_requirements; ?></div>
    </div>


</div>
