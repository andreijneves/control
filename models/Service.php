<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Service extends ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 10;

    public static function tableName()
    {
        return '{{%service}}';
    }

    public function behaviors()
    {
        return [TimestampBehavior::class];
    }

    public function rules()
    {
        return [
            [['barbershop_id', 'name'], 'required'],
            [['barbershop_id', 'duration_min', 'status'], 'integer'],
            [['price'], 'number'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 120],
            [['barbershop_id'], 'exist', 'targetClass' => Barbershop::class, 'targetAttribute' => ['barbershop_id' => 'id']],
        ];
    }

    public function getBarbershop()
    {
        return $this->hasOne(Barbershop::class, ['id' => 'barbershop_id']);
    }
}
