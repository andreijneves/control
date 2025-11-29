<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\User;
use app\models\Profile;

/**
 * Console command to manage users
 */
class UserController extends Controller
{
    /**
     * Creates a new user
     * @param string $username
     * @param string $email
     * @param string $password
     * @param string $name
     * @param string $role
     */
    public function actionCreate($username, $email, $password, $name = '', $role = 'user')
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $user = new User();
            $user->username = $username;
            $user->email = $email;
            $user->setPassword($password);
            $user->generateAuthKey();
            $user->status = User::STATUS_ACTIVE;
            
            if ($user->save()) {
                $profile = new Profile();
                $profile->user_id = $user->id;
                $profile->name = $name ?: $username;
                $profile->role = $role;
                
                if ($profile->save()) {
                    $transaction->commit();
                    $this->stdout("Usuário '{$username}' criado com sucesso!\n", \yii\helpers\Console::FG_GREEN);
                    return Controller::EXIT_CODE_NORMAL;
                }
            }
            
            $transaction->rollBack();
            $this->stdout("Erro ao criar usuário:\n", \yii\helpers\Console::FG_RED);
            foreach ($user->errors as $attr => $errors) {
                foreach ($errors as $error) {
                    $this->stdout("  - {$attr}: {$error}\n", \yii\helpers\Console::FG_RED);
                }
            }
            return Controller::EXIT_CODE_ERROR;
            
        } catch (\Exception $e) {
            $transaction->rollBack();
            $this->stdout("Erro: {$e->getMessage()}\n", \yii\helpers\Console::FG_RED);
            return Controller::EXIT_CODE_ERROR;
        }
    }

    /**
     * Lists all users
     */
    public function actionList()
    {
        $users = User::find()->with('profile')->all();
        
        if (empty($users)) {
            $this->stdout("Nenhum usuário encontrado.\n", \yii\helpers\Console::FG_YELLOW);
            return Controller::EXIT_CODE_NORMAL;
        }
        
        $this->stdout("Lista de Usuários:\n\n", \yii\helpers\Console::FG_GREEN);
        $this->stdout(str_pad("ID", 5) . str_pad("Username", 20) . str_pad("Email", 30) . str_pad("Nome", 20) . "Perfil\n");
        $this->stdout(str_repeat("-", 95) . "\n");
        
        foreach ($users as $user) {
            $profile = $user->profile;
            $this->stdout(
                str_pad($user->id, 5) . 
                str_pad($user->username, 20) . 
                str_pad($user->email, 30) . 
                str_pad($profile->name ?? '', 20) . 
                ($profile->role ?? '') . "\n"
            );
        }
        
        return Controller::EXIT_CODE_NORMAL;
    }
}
