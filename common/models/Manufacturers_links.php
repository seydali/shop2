<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "manufacturers_links".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $manufacturer_id
 */
class Manufacturers_links extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'manufacturers_links';
    }

    public function rules()
    {
        return [
            [['product_id', 'manufacturer_id'], 'required'],
            [['product_id', 'manufacturer_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'manufacturer_id' => 'Manufacturer ID',
        ];
    }

    public static function findByLink($productId, $manufId)
    {
        return parent::find()->where(['=', 'product_id', $productId])->andWhere(['=', 'manufacturer_id', $manufId])->one();
    }

    public static function findOrCreateByLink($productId, $manufId)
    {
        $res = self::findByLink($productId, $manufId);
        if ($res) {
            return $res->id;
        }
        $newManufacturersLinks = new Manufacturers_links();
        $newManufacturersLinks->product_id = $productId;
        $newManufacturersLinks->manufacturer_id = $manufId;

        if ($newManufacturersLinks->save()) return $newManufacturersLinks->id;
        return null;

    }
}
