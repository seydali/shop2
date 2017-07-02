<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SharesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Shares';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shares-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Shares', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        //'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
        'columns' => [
            [
                'label' => 'Статус',
                'format' => 'raw',
                'value' => function ($data) {
                    if ($data->status == 1) {
                        return Html::img('http://allecolife.ru/images/sampledata/galka.png', [
                            'style' => 'width:15px;'
                        ]);
                    }
                    return Html::img('http://s1.iconbird.com/ico/0612/prettyoffice/w256h2561339405847Delete256.png', [
                        'style' => 'width:15px;'
                    ]);
                },
            ],
            'title',
            'description',
            'duration',
            //'status:image',


            'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
