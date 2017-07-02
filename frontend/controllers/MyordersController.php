<?php

namespace frontend\controllers;
use Yii;
use common\models\Orders_links;
use common\models\Orders;
use common\models\Products;
use yii\helpers\Url;
class MyordersController extends \yii\web\Controller
{
    public function actionIndex()
    {

        if(Yii::$app->user->id!=NULL)
       {
           $orders=Orders::find()->where(['=', 'id_user',Yii::$app->user->id])->all();
           return $this->render('index',array(
               'myOrder'=>$orders,
           ));

       }

        else
        {
            return $this->redirect( Url::to(['site/index']));
        }
    }

}
