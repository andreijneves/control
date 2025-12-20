<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Horario extends ActiveRecord
{
    const DOMINGO = 0;
    const SEGUNDA = 1;
    const TERCA = 2;
    const QUARTA = 3;
    const QUINTA = 4;
    const SEXTA = 5;
    const SABADO = 6;

    public static function tableName()
    {
        return '{{%horario}}';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => date('Y-m-d H:i:s'),
            ],
        ];
    }

    public function rules()
    {
        return [
            [['empresa_id', 'dia_semana'], 'required'],
            [['funcionario_id', 'empresa_id', 'dia_semana'], 'integer'],
            [['hora_inicio', 'hora_fim'], 'string', 'max' => 8],
            [['disponivel'], 'boolean'],
            [['dia_semana_texto'], 'string', 'max' => 20],
            [['funcionario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Funcionario::class, 'targetAttribute' => ['funcionario_id' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresa::class, 'targetAttribute' => ['empresa_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'funcionario_id' => 'Funcionário',
            'empresa_id' => 'Empresa',
            'dia_semana' => 'Dia da Semana',
            'dia_semana_texto' => 'Dia',
            'hora_inicio' => 'Hora Início',
            'hora_fim' => 'Hora Fim',
            'disponivel' => 'Disponível',
            'created_at' => 'Criado em',
            'updated_at' => 'Atualizado em',
        ];
    }

    public function getFuncionario()
    {
        return $this->hasOne(Funcionario::class, ['id' => 'funcionario_id']);
    }

    public function getEmpresa()
    {
        return $this->hasOne(Empresa::class, ['id' => 'empresa_id']);
    }

    public static function diasSemana()
    {
        return [
            self::DOMINGO => 'Domingo',
            self::SEGUNDA => 'Segunda-feira',
            self::TERCA => 'Terça-feira',
            self::QUARTA => 'Quarta-feira',
            self::QUINTA => 'Quinta-feira',
            self::SEXTA => 'Sexta-feira',
            self::SABADO => 'Sábado',
        ];
    }

    public function getDiaSemanaLabel()
    {
        $dias = self::diasSemana();
        return $dias[$this->dia_semana] ?? 'Desconhecido';
    }
}
