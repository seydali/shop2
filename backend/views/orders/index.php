<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel common\models\OrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать заказ', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

           // 'id',


            [
                'attribute' => 'id',
                'format' => 'raw',
                'value' => function($searchModel){
                    return Html::a(Html::encode($searchModel->id), Url::to(['view', 'id' =>$searchModel->id]));
                }
            ],
            'created_at',
            'updated_at',
            ['attribute'=>'fullname',
                'label'=>'ФИО',

                'format'=>'text', // Возможные варианты: raw, html
                'content'=>function($searchModel){
                    return $searchModel->getFullname();
             }],
            //'fullname',
            'sum',
            //'status',
            'orderstat',
            // 'params',

            // 'address',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
