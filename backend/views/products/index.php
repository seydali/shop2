<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Продукты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать продукт', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'description',
            //'version',
            //'system_requirements',
            //'reviews',
            // 'status',
            // 'created_at',
            // 'updated_at',
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function($searchModel){
                    return Html::a(Html::encode($searchModel->name), Url::to(['view', 'id' =>$searchModel->id]));
                }
            ],
            //'name',
            'price',


            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
