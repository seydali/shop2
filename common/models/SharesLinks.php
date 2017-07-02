<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "shares_links".
 *
 * @property integer $id
 * @property integer $id_share
 * @property integer $id_product
 * @property integer $discount
 */
class SharesLinks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shares_links';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_share', 'id_product', 'discount'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_share' => 'Id Share',
            'id_product' => 'Id Product',
            'discount' => 'Discount',
        ];
    }
}
