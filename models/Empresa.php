<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Empresa extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%empresa}}';
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
            [['nome'], 'required'],
            [['nome', 'email'], 'string', 'max' => 255],
            [['cnpj'], 'string', 'max' => 18],
            [['cnpj'], 'unique'],
            [['telefone'], 'string', 'max' => 20],
            [['endereco', 'descricao'], 'string'],
            [['cidade'], 'string', 'max' => 100],
            [['status'], 'integer'],
            [['email'], 'email'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome da Empresa',
            'cnpj' => 'CNPJ',
            'email' => 'E-mail',
            'telefone' => 'Telefone',
            'endereco' => 'Endereço',
            'descricao' => 'Descrição',
            'cidade' => 'Cidade',
            'status' => 'Status',
            'created_at' => 'Criado em',
            'updated_at' => 'Atualizado em',
        ];
    }

    public function getUsuarios()
    {
        return $this->hasMany(Usuario::class, ['empresa_id' => 'id']);
    }

    public function getFuncionarios()
    {
        return $this->hasMany(Funcionario::class, ['empresa_id' => 'id']);
    }

    public function getServicos()
    {
        return $this->hasMany(Servico::class, ['empresa_id' => 'id']);
    }

    public function getClientes()
    {
        return $this->hasMany(Cliente::class, ['empresa_id' => 'id']);
    }

    public function getAgendamentos()
    {
        return $this->hasMany(Agendamento::class, ['empresa_id' => 'id']);
    }
}
