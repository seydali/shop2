<?php

namespace frontend\controllers;

use common\models\UserBasket;
use yii;
use yii\web\Session;
use common\models\Products;
use common\models\BasketItem;

class BasketController extends \yii\web\Controller
{


    public function actionIndex()
    {
        if (Yii::$app->user->id == NULL) {
            $products = BasketItem::getSessionProducts();
            return $this->render('index', ['products' => $products]);
        } else {
            $products = UserBasket::getDbBasket();
            return $this->render('index', ['products' => $products]);
        }
    }

    public function actionDelete($productId)
    {
        $product = Products::find()->where(['=', 'id', $productId])->one();

        if (!$product) return 'Продукт не найден!' . $productId;
        if (Yii::$app->user->id == NULL) {
            $session = Yii::$app->session;
            if (!$session->isActive)
                $session->open();
            if (empty($session['cart']))
                $session['cart'] = array();

            $arr = $session['cart'];

            $arrSearch = self::getItemByIdInArray($arr['prod'], $productId);
            //$arrSearch=array_search($productId, $arr['id']);

            if (sizeof($arrSearch) > 0) {
                $arrKey = array_keys($arrSearch);
                unset ($arr['prod'][$arrKey[0]]);
            }

            $session['cart'] = $arr;
            //echo Url::toRoute(['',false]);
            //$this->redirect('?r=basket');
            return;
        } else {
            UserBasket::delProd($productId);
            return;
        }
    }

    public static function getItemByIdInArray(&$arr, $productId)
    {
        $arrSearch = array();
        if ($arr == null) return $arrSearch;
        $arrSearch = array_filter(
            $arr,
            function ($e) use (&$productId) {
                return $e->id == $productId;
            });
        return $arrSearch;
    }

    public function actionUpdate($productId, $act)
    {
        if (Yii::$app->user->id == NULL) {
            $product = Products::find()->where(['=', 'id', $productId])->one();
            if (!$product) return 'Продукт не найден!';
            /*
            $session = new Session;

            $session->open();
            */
            $session = Yii::$app->session;
            if (!$session->isActive)
                $session->open();
            if (empty($session['cart']))
                $session['cart'] = array();

            $arr = $session['cart'];
        } else {
            $arr = UserBasket::getDbBasket();

        }
        //
        $arrSearch = self::getItemByIdInArray($arr['prod'], $productId);

        //$arrSearch=array_search($productId, $arr['id']);

        if (sizeof($arrSearch) > 0) {
            $arrKey = array_keys($arrSearch);
            if ($act == 'add') {
                $arrSearch[$arrKey[0]]->count++;
                //echo $arrSearch[$arrKey[0]]->count;
            } elseif ($act == 'sub' && $arrSearch[$arrKey[0]]->count > 1) {
                $arrSearch[$arrKey[0]]->count--;
            } elseif ($act == 'sub' && $arrSearch[$arrKey[0]]->count == 1) {
                unset ($arr['prod'][$arrKey[0]]);
            }

        } else {
            echo 'такого товара нет в вашей корзине';
        }
        if (Yii::$app->user->id == NULL) {
            $session['cart'] = $arr;
        } else {
            UserBasket::setDbBasket($arr);
        }
        return;
    }


    public function actionAdd($productId, $addCount)
    {

        $product = Products::find()->where(['=', 'id', $productId])->one();
        if (!$product) return 'Продукт не найден!';

        $arr = $this::getBasket();
        if (empty($arr)) {
            $arr = array();

        }
        if (empty($arr['prod'])) {
            $arr['prod'] = array();
        }

        $arrSearch = self::getItemByIdInArray($arr['prod'], $productId);
        if (sizeof($arrSearch) > 0) {
            $arrKey = array_keys($arrSearch);
            $arrSearch[$arrKey[0]]->count += $addCount;
            // $arr['itog']['count']=$arr['itog']['count']++;
            // $arr['itog']['sum']=$arr['itog']['sum']+$product->price;
        } else {
            $item = new BasketItem;
            $item->id = $product->id;
            if ($addCount == 1) {
                $item->count = 1;
            } elseif ((int)$addCount >= 1) {
                $item->count = $addCount;
            }
            $arr['prod'][] = $item;
            //  $arr['itog']['count']=$arr['itog']['count']++;
            //   $arr['itog']['sum']=$arr['itog']['sum']+$product->price;
        }
        BasketItem::calcItog($arr, $arr);
        $this->setBasket($arr);
        // $session['cart'] = $arr;


        //echo 'товар добавлен в корзину.';
        $session = new Session;

        var_dump($session['cart']);//'товар добавлен в корзину.';


    }

    public static function getBasket()
    {

        if (Yii::$app->user->id == NULL) {
            $arr = BasketItem::getSessionProducts();
            //die(var_dump($arr));
        } else {
            $arr = UserBasket::getDbBasket();
        }
        return $arr;
    }

    public function setBasket($arr)
    {

        if (Yii::$app->user->id == NULL) {
            $session = BasketItem::initSession();
            $session['cart'] = $arr;
            //$session->close();
            //var_dump($session['cart']);
            // echo '55';
        } else {
            $res = UserBasket::setDbBasket($arr);
            return $res;
        }
    }

    public function actionContent()
    {
        $basket = BasketItem::getSessionContent();

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $basket;
    }
}
