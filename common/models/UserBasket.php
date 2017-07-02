<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_basket".
 *
 * @property integer $id
 * @property integer $id_user
 * @property integer $id_product
 * @property integer $count
 * @property string $price
 * @property string $params
 * @property integer $created_at
 * @property integer $updated_at
 */
class UserBasket extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public static function tableName()
    {
        return 'user_basket';
    }

    public static function getDbBasket()
    {
        $userId = Yii::$app->user->id;
        $basket = UserBasket::find()->where(['=', 'id_user', $userId])->all();
        $resBasket['prod'] = array();
        $count = 0;
        $resBasket['itog']['count'] = 0;
        $resBasket['itog']['sum'] = 0;
        foreach ($basket as $item) {
            $count += $item->count;
            $vars = new Vars();
            $vars->id = $item->id_product;
            $vars->count = $item->count;
            $vars->pInfo = Products::find()->where(['=', 'id', $item->id_product])->one();
            array_push($resBasket['prod'], $vars);
            $resBasket['itog']['count'] += $item->count;
            $resBasket['itog']['sum'] += $vars->pInfo->price * $item->count;
        }

        return $resBasket;
    }

    public static function setDbBasket($arr)
    {
        //var_dump($arr);
        $userId = Yii::$app->user->id;
        UserBasket::deleteAll('id_user = :id_user ', ['id_user' => $userId]);
        foreach ($arr['prod'] as $value) {
            $newBasket = new UserBasket();
            $newBasket->id_user = $userId;
            $newBasket->id_product = $value->id;
            $newBasket->count = $value->count;
            $newBasket->save();
        }
        return true;
    }

    public static function delProd($productId)
    {
        $userId = Yii::$app->user->id;
        $userBasket = new UserBasket;
        //$basket=$userBasket->delete('user_basket',['id_user'=>$userId, 'id_product'=>$productId]);
        UserBasket::deleteAll('id_user = :id_user and id_product=:id_product', ['id_user' => $userId, 'id_product' => $productId]);
        // print_r($basket);

    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'id_product'], 'required'],
            [['id_user', 'count', 'created_at', 'updated_at'], 'integer'],
            [['price'], 'number'],
            [['params'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'id_product' => 'Id Product',
            'count' => 'Count',
            'price' => 'Price',
            'params' => 'Params',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}

class Vars
{
    public $id;
    public $count;
    public $pInfo;
}
