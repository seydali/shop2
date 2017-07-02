<?php

namespace frontend\controllers;
use common\models\Orders;
use common\models\Orders_links;
use common\models\User;
use frontend\models\Products;
use yii\web\Session;
use yii;
use common\models\LoginForm;
use yii\helpers\Url;
class OrdersController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionRegistration()
    {
        if(Yii::$app->user->id==NULL) {
            $registration=FALSE;
            return $this->redirect( Url::to(['site/signup', 'toOrder'=>'true']));
        }
        return $this->redirect( Url::to(['orders/confirm']));
        /*
        else
        {
            $registration=true;
        }
        $model = new LoginForm();
        return $this->render('registration',array(
            'registration'=>$registration,
            'model'=>$model,
        ));
        */
    }
    public function register()
    {
        $session= new Session();
        $session->open();
        if($session['reginfo'])
        {

        }
        $session->close();
    }
    public function actionCreate()
    {

    }
    public function actionConfirm()
    {
        $newAddress=Yii::$app->request->post('newAddress');
        $address= User::find()->where(['=', 'id', Yii::$app->user->id])->one();

        if($newAddress)
        {
            $orders=new Orders();

            $address->address=$newAddress;
            $address->save();
            $basket=BasketController::getBasket();
            $orders->id_user=Yii::$app->user->id;
            $orders->sum=$basket['itog']['sum'];
            $orders->count=$basket['itog']['count'];
            $orders->status=0;
            $orders->address=$newAddress;
            $orders->save();
            //var_dump($orders->errors);
            foreach($basket['prod'] as $prod)
            {
                $ordersLinks= new Orders_links();
                $ordersLinks->id_order=$orders->id;
                $ordersLinks->id_product=$prod->id;
                $ordersLinks->price=$prod->pInfo->price;
                $ordersLinks->count= $prod->count;
                $ordersLinks->save();
                //var_dump($prod->pInfo->price);
            }
            return $this->render('confirm', array('success'=>TRUE));
        }
        if($newAddress==$address->address)
        {

            return $this->render('confirm', array('success'=>TRUE));
        }

        return $this->render('confirm', array('address'=>$address));
    }

    private function info()
    {
        return $this->render('registration');
    }
}
