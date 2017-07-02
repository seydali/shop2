<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "os_links_new".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $os_id
 */
class OsLinksNew extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'os_links_new';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'os_id'], 'required'],
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
}
