<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Employee extends ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 10;

    public static function tableName()
    {
        return '{{%employee}}';
    }

    public function behaviors()
    {
        return [TimestampBehavior::class];
    }

    public function rules()
    {
        return [
            [['barbershop_id', 'name'], 'required'],
            [['barbershop_id', 'status'], 'integer'],
            [['name'], 'string', 'max' => 120],
            [['email'], 'string', 'max' => 180],
            [['email'], 'email'],
            [['phone'], 'string', 'max' => 32],
            [['barbershop_id'], 'exist', 'targetClass' => Barbershop::class, 'targetAttribute' => ['barbershop_id' => 'id']],
        ];
    }

    public function getBarbershop()
    {
        return $this->hasOne(Barbershop::class, ['id' => 'barbershop_id']);
    }
}
