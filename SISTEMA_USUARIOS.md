# Sistema de Controle - Yii2

Sistema de cadastro de usuários com perfis e autenticação desenvolvido em Yii2.

## Estrutura do Sistema

### Tabelas do Banco de Dados

#### user
- `id`: ID do usuário (chave primária)
- `username`: Nome de usuário (único)
- `auth_key`: Chave de autenticação
- `password_hash`: Hash da senha
- `password_reset_token`: Token para reset de senha
- `email`: Email (único)
- `status`: Status do usuário (10=ativo, 9=inativo, 0=deletado)
- `created_at`: Data de criação (timestamp)
- `updated_at`: Data de atualização (timestamp)

#### profile
- `id`: ID do perfil (chave primária)
- `user_id`: ID do usuário (chave estrangeira)
- `name`: Nome completo do usuário
- `role`: Perfil do usuário (user, admin, moderator)

### Modelos

- **User**: Modelo ActiveRecord com implementação de IdentityInterface para autenticação
- **Profile**: Modelo de perfil do usuário
- **LoginForm**: Formulário de login
- **SignupForm**: Formulário de cadastro

### Controllers

- **UserController**: Gerenciamento de usuários (CRUD)
  - `/user/index` - Lista de usuários (requer autenticação)
  - `/user/view/{id}` - Visualizar usuário (requer autenticação)
  - `/user/signup` - Cadastro de novo usuário (acesso público)
  - `/user/delete/{id}` - Deletar usuário (requer autenticação)

- **SiteController**: Controller padrão do Yii2
  - `/site/login` - Login
  - `/site/logout` - Logout

### Comandos de Console

#### Criar usuário via console:
```bash
php yii user/create <username> <email> <password> [name] [role]
```

Exemplo:
```bash
php yii user/create admin admin@example.com senha123 "Administrador" admin
php yii user/create usuario user@example.com senha123 "Usuário Comum" user
```

#### Listar usuários:
```bash
php yii user/list
```

## Perfis Disponíveis

- **user**: Usuário comum (padrão)
- **admin**: Administrador
- **moderator**: Moderador

## Credenciais de Teste

### Administrador
- **Username**: admin
- **Password**: admin123
- **Email**: admin@control.com

### Usuário Comum
- **Username**: usuario
- **Password**: senha123
- **Email**: usuario@control.com

## Configuração

### Banco de Dados
As configurações do banco estão em `config/db.php`:
- Database: control
- Username: dev
- Password: senha

### Autenticação
O componente de autenticação está configurado em `config/web.php`:
- Identity Class: `app\models\User`
- Auto Login: Habilitado
- Session Duration: 30 dias quando "Lembrar-me" está marcado

## Funcionalidades Implementadas

✅ Cadastro de usuários com perfil
✅ Sistema de autenticação completo
✅ Login/Logout
✅ Hash de senha com bcrypt
✅ Tokens de autenticação ("Lembrar-me")
✅ Listagem de usuários
✅ Visualização de detalhes do usuário
✅ Exclusão lógica de usuários (soft delete)
✅ Comando de console para criar usuários
✅ Timestamps automáticos (created_at, updated_at)
✅ Validação de dados
✅ Relacionamento User-Profile
✅ Interface em português

## Próximos Passos Sugeridos

- Implementar reset de senha por email
- Adicionar edição de perfil
- Implementar RBAC (Role-Based Access Control)
- Adicionar avatar do usuário
- Criar dashboard específico por perfil
- Implementar logs de atividades
- Adicionar filtros e busca na listagem de usuários

## Migrations

Para executar as migrations:
```bash
php yii migrate
```

As tabelas `user` e `profile` já estão criadas no banco de dados.
