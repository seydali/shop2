<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order_stat_links".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $status_id
 */
class OrderStatLinks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_stat_links';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'status_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'status_id' => 'Status ID',
        ];
    }
}
