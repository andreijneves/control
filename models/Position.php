<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Position extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%position}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'value' => fn() => date('Y-m-d H:i:s'),
            ],
        ];
    }

    public function rules()
    {
        return [
            [['organization_id', 'name'], 'required'],
            [['organization_id', 'status'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['description'], 'string'],
            [['status'], 'default', 'value' => 10],
            [['organization_id'], 'exist', 'skipOnError' => true, 'targetClass' => Organization::class, 'targetAttribute' => ['organization_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'organization_id' => 'Organização',
            'name' => 'Nome do Cargo',
            'description' => 'Descrição',
            'status' => 'Status',
            'created_at' => 'Criado em',
            'updated_at' => 'Atualizado em',
        ];
    }

    public function getOrganization()
    {
        return $this->hasOne(Organization::class, ['id' => 'organization_id']);
    }
}
