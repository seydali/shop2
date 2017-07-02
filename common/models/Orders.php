<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property integer $id
 * @property integer $id_user
 * @property string $sum
 * @property string $count
 * @property integer $status
 * @property string $params
 * @property string $created_at
 * @property string $updated_at
 * @property string $address
 * @property Products $product
 */
class Orders extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'orders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'sum', 'count'], 'required'],
            [['id_user', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
           // [['parentName'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id Пользователя',
            'sum' => 'Сумма',
            'count' => 'Кол-во',
            'status' => 'Статус',
            'params' => 'Паоаметры',
            'product' => 'Продукт',
            'prodinfo'=>'Информация о продукте',
            'fullname' => 'ФИО',
            'user' => 'Пользователь',
            'orderstat' => 'Cостояние',
            'created_at' => 'Добавлено',
            'updated_at' => 'Изменено',
        ];
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }
    public function getFullname()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user'])->One()->fullname;
       // $user = $this->user;

       // return $user? $user->fullname : '';
    }
    public function getProduct()
    {
        return $this->hasMany(Products::className(), ['id' => 'id_product'])
            ->viaTable('orders_links', ['id_order' => 'id'])->all();

    }
    public function getProdInfo()
    {
        return $this->hasMany(Orders_links::className(), ['id_order' => 'id']);
    }
    public function getOrderstat()
    {
        return $this->hasMany(OrderStatuses::className(), ['id' => 'status'])->one()->name;
    }
}
