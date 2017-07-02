<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "os".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 */
class Os extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */


    public static function tableName()
    {
        return 'os';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'description' => 'Описание',
        ];
    }
    public static function findByName($name)
    {
        return parent::find()->where(['=', 'name', $name])->one();
    }
    public static function findOrCreateByName($name)
    {
        $res=self::findByName($name);
        if($res)
        {
            return $res->id;
        }
        $newOs=new Os();
        $newOs->name=$name;

        if($newOs->save()) return $newOs->id;
        return null;

    }
}
