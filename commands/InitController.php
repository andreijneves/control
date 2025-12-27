<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\Usuario;
use app\models\Empresa;

class InitController extends Controller
{
    public function actionIndex()
    {
        echo "Inicializando dados de teste...\n";

        // Criar usuário admin
        $admin = new Usuario();
        $admin->username = 'admin';
        $admin->setPassword('admin123');
        $admin->generateAuthKey();
        $admin->role = Usuario::ROLE_ADMIN_GERAL;
        $admin->nome_completo = 'Administrador';
        $admin->status = 1;

        if ($admin->save()) {
            echo "✓ Usuário admin criado com sucesso!\n";
        } else {
            echo "✗ Erro ao criar usuário admin.\n";
            var_dump($admin->errors);
        }

        // Criar empresa de teste
        $empresa = new Empresa();
        $empresa->nome = 'Empresa Teste';
        $empresa->cnpj = '12345678000100';
        $empresa->email = 'contato@empresa.com';
        $empresa->telefone = '(11) 99999-9999';
        $empresa->endereco = 'Rua Teste, 123';
        $empresa->status = 1;

        if ($empresa->save()) {
            echo "✓ Empresa de teste criada com sucesso!\n";

            // Criar admin da empresa
            $adminEmpresa = new Usuario();
            $adminEmpresa->username = 'empresa_admin';
            $adminEmpresa->setPassword('empresa123');
            $adminEmpresa->generateAuthKey();
            $adminEmpresa->role = Usuario::ROLE_ADMIN_EMPRESA;
            $adminEmpresa->empresa_id = $empresa->id;
            $adminEmpresa->nome_completo = 'Administrador da Empresa';
            $adminEmpresa->email = 'admin@empresa.com';
            $adminEmpresa->status = 1;

            if ($adminEmpresa->save()) {
                echo "✓ Admin da empresa criado com sucesso!\n";
            } else {
                echo "✗ Erro ao criar admin da empresa.\n";
                var_dump($adminEmpresa->errors);
            }
        } else {
            echo "✗ Erro ao criar empresa.\n";
            var_dump($empresa->errors);
        }

        echo "\nDados de teste inicializados!\n";
        echo "\nCredenciais de teste:\n";
        echo "Admin Geral: admin / admin123\n";
        echo "Admin Empresa: empresa_admin / empresa123\n";
    }
}
