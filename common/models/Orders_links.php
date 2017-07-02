<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "orders_links".
 *
 * @property integer $id
 * @property integer $id_order
 * @property integer $id_product
 *  @property integer $count
 *  @property integer $price
 */
class Orders_links extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders_links';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_order', 'id_product'], 'required'],
            [['id_order', 'id_product', 'count'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_order' => 'Id Order',
            'id_product' => 'Id Product',
            'count'=>'количество'
        ];
    }
}
