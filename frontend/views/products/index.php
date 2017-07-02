<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Products;
use yii\widgets\LinkSorter;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
//var_dump($dataProvider->pagination->pageSize);

$this->title = 'Каталог';
$this->params['breadcrumbs'][] = $this->title;

?>



        <?php $form = ActiveForm::begin(['method' => 'get']); ?>
        <?php //var_dump($searchModel->price);?>
<div class="col-md-10 col-sm-4">
        <?= $form->field($searchModel, 'name')->label('Поиск')->textInput(['placeholder'=>"искать по назваанию.."]) ?>
 </div>
<div class="col-md-3 col-sm-4">
    <div class="search-form">
        <?= $form->field($searchModel, 'onShare')->checkbox(['title' => 'k3k', "label"=>"Только акционные предложения"]) ?>

        <?php $items = ArrayHelper::map($allShares, 'title', 'title');
        $params = [
            'prompt' => 'Выберите акцию'
        ]; ?>
        <?= $form->field($searchModel, 'selShares')->dropDownList($items, $params)->label('Акции') ?>

        <?= $form->field($searchModel, 'minPrice')->label('Цена (от):') ?>
        <?= $form->field($searchModel, 'maxPrice')->label('Цена (до):') ?>
        <?php $items = ArrayHelper::map($allCatNames, 'name', 'name');
        $params = [
            'prompt' => 'Выберите категорию'
        ]; ?>
        <?= $form->field($searchModel, 'categories')->dropDownList($items, $params) ?>

        <?php $items = ArrayHelper::map($allManNames, 'name', 'name');
        $params = [
            'prompt' => 'Выберите производителя'
        ]; ?>
        <?= $form->field($searchModel, 'manufacturers')->dropDownList($items, $params) ?>

        <?php $items = ArrayHelper::map($allOsNames, 'name', 'name');
        $params = [
            'prompt' => 'Выберите ОС'
        ]; ?>
        <?= $form->field($searchModel, 'os')->dropDownList($items, $params) ?>
        <? //= $form->field($searchModel, 'categories') ?>

        <div class="form-group">
            <?= Html::submitButton('Apply', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
<div class="col-md-9 col-sm-4">
    <div class="products-index">
        <h1><?= Html::encode($this->title) ?></h1>
        <p>Сортировать</p>
        <?= ListView::widget([
            'layout' => "{sorter}\n{summary}\n{items}\n{pager}",

            'sorter' => [
                'class' => LinkSorter::className(),
            ],
            'dataProvider' => $dataProvider,
            'itemOptions' => ['id' => 'catBorder'],
            'itemView' => function ($model, $key, $index, $widget) {
                return
                    Html::a(Html::encode($model->name), ['view', 'id' => $model->id]) .
                    ($model->oldprice != NULL ? "<div id='productOldPrice' ><strong><s>" . Html::encode($model->oldprice) . " руб.</s></strong>" . "</div><br><div id='productPrice'><strong>" . Html::encode($model->price) . " руб.</strong>" . "</div>" : "<div id='productPrice'><strong>" . Html::encode($model->price) . " руб.</strong>" . "</div>")
                    .
                    '<div>' . HTML::img(Html::encode(str_replace('uploads', 'uploads/min/150', $model->image))) . '</div>'
                    . '<div>' . ($model->shareicon ? HTML::img(Html::encode(str_replace('uploads/icons', 'uploads/icons/min/40', $model->shareicon)), ['style' => "position: relative;
          top: -150px;
           left: 130px;"]) : '') . '</div>' .


                    "<div id='description'>" . mb_substr($model->description, 0, mb_strpos($model->description, '</p>')) . "</p></div>" .

                    '<div class="number">

                <a href="#" class="minus">-</a>
                   <input type="text" name="counter" id="counter' . $model->id . '" value="1" size="1"/>
                <a href="#" class="plus">+</a>
            </div> ' .
                    "<div id='productBuy'>" .
                    HTML::a('В КОРЗИНУ', '#', ['class' => 'productBuy', 'id' => 'pjaxBuy', 'productId' => $model->id]) .
                    "</div>";
            },
        ]) ?>
    </div>

</div>