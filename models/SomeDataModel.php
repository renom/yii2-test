<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "some_data_model".
 *
 * @property int $id
 * @property int $user_id
 * @property int $type
 * @property string $date
 * @property int $a
 * @property string $b
 *
 * @property User $user
 */
class SomeDataModel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'some_data_model';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'type', 'date', 'a', 'b'], 'required'],
            [['user_id', 'type', 'a'], 'integer'],
            [['date'], 'date', 'format' => 'php:Y-m-d'],
            [['b'], 'string', 'max' => 45],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'type' => 'Type',
            'date' => 'Date',
            'a' => 'A',
            'b' => 'B',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
