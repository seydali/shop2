<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "product_links".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $category_id
 */
class Product_links extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_links';
    }

    public static function findOrCreateByLink($productId, $categoryId)
    {
        $res = self::findByLink($productId, $categoryId);
        if ($res) {
            return $res->id;
        }
        $newProductLinks = new Product_links();
        $newProductLinks->product_id = $productId;
        $newProductLinks->category_id = $categoryId;

        if ($newProductLinks->save()) return $newProductLinks->id;
        return null;

    }

    public static function findByLink($productId, $categoryId)
    {
        return parent::find()->where(['=', 'product_id', $productId])->andWhere(['=', 'category_id', $categoryId])->one();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['product_id', 'category_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'ID продукта',
            'category_id' => 'ID категории',
        ];
    }
}
