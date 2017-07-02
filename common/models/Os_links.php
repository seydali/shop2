<?php
namespace common\models;

use Yii;

/**
 * This is the model class for table "os_links".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $os_id
 */
class Os_links extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'os_links';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['product_id', 'os_id'], 'required'],
            [['product_id', 'os_id'], 'integer'],
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
            'os_id' => 'Os ID',
        ];
    }
    public static function findByLink($productId, $osId)
    {
        return parent::find()->where(['=', 'product_id', $productId])->andWhere(['=', 'os_id', $osId])->one();
    }
    public static function findOrCreateByLink($productId, $osId)
    {
        $res=self::findByLink($productId, $osId);
        if($res)
        {
            return $res->id;
        }
        $newOsLink=new Os_links();
        $newOsLink->product_id=$productId;
        $newOsLink->os_id=$osId;

        if($newOsLink->save()) return $newOsLink->id;
        return null;

    }
}
