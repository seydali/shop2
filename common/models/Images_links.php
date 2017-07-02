<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "images_links".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $image_id
 */
class Images_links extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'images_links';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'image_id'], 'integer'],
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
            'image_id' => 'Image ID',
        ];
    }

    public static function findByLink($productId, $imageId)
    {
        return parent::find()->where(['=', 'product_id', $productId])->andWhere(['=', 'image_id', $imageId])->one();
    }

    public static function findOrCreateByLink($productId, $imageId)
    {
        $res = self::findByLink($productId, $imageId);
        if ($res) {
            return $res->id;
        }
        $newImagesLink = new Images_links();
        $newImagesLink->product_id = $productId;
        $newImagesLink->image_id = $imageId;

        if ($newImagesLink->save()) return $newImagesLink->id;
        return null;

    }
}
