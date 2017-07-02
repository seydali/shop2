<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_stat_links".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $status_id
 */
class UserStatLinks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_stat_links';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'status_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'status_id' => 'Status ID',
        ];
    }
}
