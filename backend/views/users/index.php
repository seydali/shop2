<?php

use yii\helpers\Html;
use yii\grid\GridView;use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать пользователя', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?//var_dump($searchModel->userstat); die;?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
         //   ['class' => 'yii\grid\SerialColumn'],

            //'id',
           // 'username',
            [
                'attribute' => 'name',
                'format' => 'raw',
                'label'=>'Имя пользователя',
                'value' => function($searchModel){
                    return Html::a(Html::encode($searchModel->username), Url::to(['view', 'id' =>$searchModel->id]));
                }
            ],
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            // 'email:email',
             'userstat',
            // 'created_at',
            // 'updated_at',
             'fullname',
            // 'address',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
