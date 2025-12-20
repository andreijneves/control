<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Servico extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%servico}}';
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
            [['empresa_id', 'nome', 'preco'], 'required'],
            [['empresa_id', 'duracao_minutos'], 'integer'],
            [['nome'], 'string', 'max' => 255],
            [['descricao'], 'string'],
            [['preco'], 'number'],
            [['status'], 'integer'],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresa::class, 'targetAttribute' => ['empresa_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'empresa_id' => 'Empresa',
            'nome' => 'Nome do Serviço',
            'descricao' => 'Descrição',
            'preco' => 'Preço',
            'duracao_minutos' => 'Duração (minutos)',
            'status' => 'Status',
            'created_at' => 'Criado em',
            'updated_at' => 'Atualizado em',
        ];
    }

    public function getEmpresa()
    {
        return $this->hasOne(Empresa::class, ['id' => 'empresa_id']);
    }

    public function getAgendamentos()
    {
        return $this->hasMany(Agendamento::class, ['servico_id' => 'id']);
    }
}
