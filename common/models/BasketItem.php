<?php
namespace common\models;

use yii\web\Session;
use common\models\Products;
use Yii;
use yii\base\Model;


class BasketItem extends Model
{
    public $id;
    public $count;
    public $pInfo;

    public function behaviors()
    {
        return [
        ];
    }

    public function rules()
    {
        return [

        ];
    }

    public static function initSession()
    {
        $session = Yii::$app->session;
        if (!$session->isActive)
            $session->open();
        return $session;
    }

    public static function calcItog(&$arr, &$res)
    {
        $res['items'] = array();
        $res['itog']['count'] = 0;
        $res['itog']['sum'] = 0;
        $sum = 0;
        $count = 0;
        foreach ($arr['prod'] as $obj) {
            $prod = Products::find()->where(['=', 'id', $obj->id])->one();
            $sum += $obj->count * $prod->price;
            $count += $obj->count;
        }
        $res['itog']['count'] = $count;
        $res['itog']['sum'] = $sum;

    }


    public static function getSessionContent()
    {
        if (Yii::$app->user->id == NULL) {
            $session = self::initSession();
            $res = array();
            if (empty($session['cart'])) return $res;
            $arr = $session['cart'];
            self::calcItog($arr, $res);
            $res['items'] = $session['cart']['prod'];
        } else {
            $arr = UserBasket::getDbBasket();
            self::calcItog($arr, $res);
            $res['items'] = $arr['prod'];
        }
        return $res;

    }

    public static function getSessionProducts()
    {

        $session = self::initSession();
        //return $session['cart'];
        if (empty($session['cart'])) return null;
        $arr = $session['cart'];

        foreach ($arr['prod'] as $obj) {

            //if(empty($obj->count))continue;
            //if(empty($obj->id))continue;
            $product = Products::find()->where(['=', 'id', $obj->id])->one();
            $item = new BasketItem;
            $item->id = $product->id;
            $item->count = $obj->count;
            $item->pInfo = $product;
            $res['prod'][] = $item;

        }

        self::calcItog($arr, $res);
        return $res;

    }


    public static function addBasketItem($productId)
    {
        /*
        $session = new Session;
        $session->open();
        */
        $session = Yii::$app->session;
        if (!$session->isActive)
            $session->open();
        if (empty($session['cart'])) return null;
        $arr = $session['cart'];
        foreach ($arr as $obj) {
            if (Products::find()->where(['=', 'id', $obj->id])->one()) {
                $basket = new UserBasket();
                //$res['itog']['count']
            } else {
                return null;
            }
        }
    }

}
