<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 */
class Categories extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'description'], 'string', 'max' => 255],
            [['name'], 'unique'],
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
        $res = self::findByName($name);
        if ($res) {
            return $res->id;
        }
        $newCategory = new Categories();
        $newCategory->name = $name;

        if ($newCategory->save()) return $newCategory->id;
        return $newCategory;

    }
}
