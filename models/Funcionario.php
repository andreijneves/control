<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Funcionario extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%funcionario}}';
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
            [['usuario_id', 'empresa_id', 'nome'], 'required'],
            [['usuario_id', 'empresa_id'], 'integer'],
            [['nome', 'email'], 'string', 'max' => 255],
            [['cpf', 'telefone'], 'string', 'max' => 20],
            [['cargo'], 'string', 'max' => 100],
            [['status'], 'integer'],
            [['email'], 'email'],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::class, 'targetAttribute' => ['usuario_id' => 'id']],
            [['empresa_id'], 'exist', 'skipOnError' => true, 'targetClass' => Empresa::class, 'targetAttribute' => ['empresa_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario_id' => 'Usuário',
            'empresa_id' => 'Empresa',
            'nome' => 'Nome',
            'cpf' => 'CPF',
            'email' => 'E-mail',
            'telefone' => 'Telefone',
            'cargo' => 'Cargo',
            'status' => 'Status',
            'created_at' => 'Criado em',
            'updated_at' => 'Atualizado em',
        ];
    }

    public function getUsuario()
    {
        return $this->hasOne(Usuario::class, ['id' => 'usuario_id']);
    }

    public function getEmpresa()
    {
        return $this->hasOne(Empresa::class, ['id' => 'empresa_id']);
    }

    public function getHorarios()
    {
        return $this->hasMany(Horario::class, ['funcionario_id' => 'id']);
    }

    public function getAgendamentos()
    {
        return $this->hasMany(Agendamento::class, ['funcionario_id' => 'id']);
    }
}
