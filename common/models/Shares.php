<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "shares".
 *
 * @property integer $id
 * @property string $title
 * @property string $duration
 * @property string $icon
 * @property string $created_at
 *  @property integer $discount
 * @property integer $status
 */
class Shares extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $iconim;

    public static function tableName()
    {
        return 'shares';
    }
    public function AddImage($image)
    {
        if($this->id>0)
            $this->save();
        return Images::findOrCreateByPath($image);

    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at','iconim','discount','status','from','to'], 'safe'],
            [['title', 'duration', 'icon','description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'duration' => 'Длительность',
            'icon' => 'Иконка',
            'discount' =>'Скидка',
            'description' =>'Описание',
            'prodlist'=>'Prodlist',
            'created_at' => 'Created At',
            'iconimg'=>'img',
            'status'=>'Статус',
            'from'=>'Начало',
            'to'=>'Окончание'
        ];
    }
    public function getProdlist()
    {
        return $this->hasMany(Products::className(), ['id' => 'id_product'])
            ->viaTable('shares_links', ['id_share' => 'id'])->all();
    }
    public function getIconimg()
    {
        return $this->hasOne(Images::className(), ['id' => 'icon']);
    }

    public static function  clearOlderRows()
    {
        $currTime= date('Y-m-d H:i:s');
        $delshares= Shares::find()->where(['AND',['=','status','1'],['<=', 'to',$currTime]])->all();
        foreach($delshares as $delshare)
        {
            $sharesLinks=SharesLinks::find()->where(['=', 'id_share', $delshare->id])->all();
            foreach($sharesLinks as $sharesLink) {
                $prod = Products::find()->where(['=', 'id', $sharesLink->id_product])->one();
                if ($prod != null) {
                    $prod->price = $prod->oldprice;
                    $prod->oldprice = NULL;
                    $prod->save();
                }
            }
            $delshare->status=0;
            $delshare->save();
        }
        $upShares= Shares::find()->where(['>=', 'to',$currTime])->all();
        foreach($upShares as $upShare)
        {
            $upShare->status=1;
            $upShare->save();
        }
    }
}
