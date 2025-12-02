<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Appointment extends ActiveRecord
{
    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_COMPLETED = 'completed';

    public static function tableName()
    {
        return '{{%appointment}}';
    }

    public function behaviors()
    {
        return [TimestampBehavior::class];
    }

    public function rules()
    {
        return [
            [['barbershop_id', 'service_id', 'employee_id', 'client_name', 'appointment_date', 'appointment_time'], 'required'],
            [['barbershop_id', 'service_id', 'employee_id'], 'integer'],
            [['appointment_date', 'appointment_time'], 'safe'],
            [['notes'], 'string'],
            [['client_name'], 'string', 'max' => 120],
            [['client_email'], 'string', 'max' => 180],
            [['client_email'], 'email'],
            [['client_phone'], 'string', 'max' => 32],
            [['status'], 'string', 'max' => 32],
            [['status'], 'in', 'range' => [self::STATUS_PENDING, self::STATUS_CONFIRMED, self::STATUS_CANCELLED, self::STATUS_COMPLETED]],
            [['barbershop_id'], 'exist', 'targetClass' => Barbershop::class, 'targetAttribute' => ['barbershop_id' => 'id']],
            [['service_id'], 'exist', 'targetClass' => Service::class, 'targetAttribute' => ['service_id' => 'id']],
            [['employee_id'], 'exist', 'targetClass' => Employee::class, 'targetAttribute' => ['employee_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'barbershop_id' => 'Barbearia',
            'service_id' => 'Serviço',
            'employee_id' => 'Funcionário',
            'client_name' => 'Nome do Cliente',
            'client_email' => 'E-mail',
            'client_phone' => 'Telefone',
            'appointment_date' => 'Data',
            'appointment_time' => 'Horário',
            'status' => 'Status',
            'notes' => 'Observações',
        ];
    }

    public function getBarbershop()
    {
        return $this->hasOne(Barbershop::class, ['id' => 'barbershop_id']);
    }

    public function getService()
    {
        return $this->hasOne(Service::class, ['id' => 'service_id']);
    }

    public function getEmployee()
    {
        return $this->hasOne(Employee::class, ['id' => 'employee_id']);
    }

    public static function getStatuses()
    {
        return [
            self::STATUS_PENDING => 'Pendente',
            self::STATUS_CONFIRMED => 'Confirmado',
            self::STATUS_CANCELLED => 'Cancelado',
            self::STATUS_COMPLETED => 'Concluído',
        ];
    }

    public function getStatusLabel()
    {
        $statuses = self::getStatuses();
        return $statuses[$this->status] ?? $this->status;
    }
}
