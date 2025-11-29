<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Profile model
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $name
 * @property string $role
 */
class Profile extends ActiveRecord
{
    const ROLE_USER = 'user';
    const ROLE_ADMIN = 'admin';
    const ROLE_MODERATOR = 'moderator';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%profile}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['role'], 'string', 'max' => 50],
            ['role', 'default', 'value' => self::ROLE_USER],
            ['role', 'in', 'range' => [self::ROLE_USER, self::ROLE_ADMIN, self::ROLE_MODERATOR]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'name' => 'Nome',
            'role' => 'Perfil',
        ];
    }

    /**
     * Get user
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Get available roles
     */
    public static function getRolesList()
    {
        return [
            self::ROLE_USER => 'Usuário',
            self::ROLE_ADMIN => 'Administrador',
            self::ROLE_MODERATOR => 'Moderador',
        ];
    }
}
