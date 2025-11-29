<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $password_repeat;
    public $name;
    public $role;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password', 'password_repeat'], 'required'],
            ['username', 'trim'],
            ['username', 'string', 'min' => 3, 'max' => 255],
            ['username', 'unique', 'targetClass' => User::class, 'message' => 'Este username já está em uso.'],
            
            ['email', 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'Este email já está em uso.'],
            
            ['password', 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'As senhas não coincidem.'],
            
            ['name', 'string', 'max' => 255],
            ['role', 'default', 'value' => Profile::ROLE_USER],
            ['role', 'in', 'range' => array_keys(Profile::getRolesList())],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Usuário',
            'email' => 'Email',
            'password' => 'Senha',
            'password_repeat' => 'Confirmar Senha',
            'name' => 'Nome',
            'role' => 'Perfil',
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->status = User::STATUS_ACTIVE;
            
            if ($user->save()) {
                $profile = new Profile();
                $profile->user_id = $user->id;
                $profile->name = $this->name;
                $profile->role = $this->role;
                
                if ($profile->save()) {
                    $transaction->commit();
                    return $user;
                }
            }
            
            $transaction->rollBack();
        } catch (\Exception $e) {
            $transaction->rollBack();
            Yii::error($e->getMessage());
        }
        
        return null;
    }
}
