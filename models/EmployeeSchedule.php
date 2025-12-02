<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class EmployeeSchedule extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%employee_schedule}}';
    }

    public function behaviors()
    {
        return [TimestampBehavior::class];
    }

    public function rules()
    {
        return [
            [['employee_id', 'day_of_week', 'start_time', 'end_time'], 'required'],
            [['employee_id', 'day_of_week'], 'integer'],
            [['start_time', 'end_time'], 'safe'],
            [['day_of_week'], 'in', 'range' => [0, 1, 2, 3, 4, 5, 6]],
            [['employee_id'], 'exist', 'targetClass' => Employee::class, 'targetAttribute' => ['employee_id' => 'id']],
            ['end_time', 'compare', 'compareAttribute' => 'start_time', 'operator' => '>', 'message' => 'Horário final deve ser após o inicial.'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'employee_id' => 'Funcionário',
            'day_of_week' => 'Dia da Semana',
            'start_time' => 'Horário Início',
            'end_time' => 'Horário Fim',
        ];
    }

    public function getEmployee()
    {
        return $this->hasOne(Employee::class, ['id' => 'employee_id']);
    }

    public static function getDaysOfWeek()
    {
        return [
            0 => 'Domingo',
            1 => 'Segunda-feira',
            2 => 'Terça-feira',
            3 => 'Quarta-feira',
            4 => 'Quinta-feira',
            5 => 'Sexta-feira',
            6 => 'Sábado',
        ];
    }

    public function getDayName()
    {
        $days = self::getDaysOfWeek();
        return $days[$this->day_of_week] ?? '';
    }
}
