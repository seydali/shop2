<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SharesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Акции';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shares-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model->title), ['view', 'id' => $model->id]) .
            "<div>" . ($model->iconimg->path ? HTML::img(Html::encode(str_replace('uploads/icons', 'uploads/icons/min/40', $model->iconimg->path))) :
                HTML::img(Html::encode('http://www.autostandart.com/graph/noimage.png'), ['height' => '40'])) .
            "</div>
            <strong>ОПИСАНИЕ:</strong>
            <div>" . $model->description . "</div>
            <strong>с:</strong>
            " . $model->created_at . "<br>";
        },
    ]) ?>
</div>
