<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Agendamento extends ActiveRecord
{
    const STATUS_PENDENTE = 'pendente';
    const STATUS_CONFIRMADO = 'confirmado';
    const STATUS_CANCELADO = 'cancelado';
    const STATUS_CONCLUIDO = 'concluido';

    public static function tableName()
    {
        return '{{%agendamento}}';
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
            [['cliente_id', 'funcionario_id', 'servico_id', 'empresa_id', 'data_agendamento'], 'required'],
            [['cliente_id', 'funcionario_id', 'servico_id', 'empresa_id'], 'integer'],
            [['data_agendamento'], 'datetime', 'format' => 'yyyy-MM-dd HH:mm:ss'],
            [['observacoes'], 'string'],
            [['status'], 'string', 'max' => 20],
            [['cliente_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cliente::class, 'targetAttribute' => ['cliente_id' => 'id']],
            [['funcionario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Funcionario::class, 'targetAttribute' => ['funcionario_id' => 'id']],
            [['servico_id'], 'exist', 'skipOnError' => true, 'targetClass' => Servico::class, 'targetAttribute' => ['servico_id' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresa::class, 'targetAttribute' => ['empresa_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cliente_id' => 'Cliente',
            'funcionario_id' => 'Funcionário',
            'servico_id' => 'Serviço',
            'empresa_id' => 'Empresa',
            'data_agendamento' => 'Data do Agendamento',
            'status' => 'Status',
            'observacoes' => 'Observações',
            'created_at' => 'Criado em',
            'updated_at' => 'Atualizado em',
        ];
    }

    public function getCliente()
    {
        return $this->hasOne(Cliente::class, ['id' => 'cliente_id']);
    }

    public function getFuncionario()
    {
        return $this->hasOne(Funcionario::class, ['id' => 'funcionario_id']);
    }

    public function getServico()
    {
        return $this->hasOne(Servico::class, ['id' => 'servico_id']);
    }

    public function getEmpresa()
    {
        return $this->hasOne(Empresa::class, ['id' => 'empresa_id']);
    }

    public static function statusOptions()
    {
        return [
            self::STATUS_PENDENTE => 'Pendente',
            self::STATUS_CONFIRMADO => 'Confirmado',
            self::STATUS_CANCELADO => 'Cancelado',
            self::STATUS_CONCLUIDO => 'Concluído',
        ];
    }

    public function getStatusLabel()
    {
        $options = self::statusOptions();
        return $options[$this->status] ?? 'Desconhecido';
    }
}
