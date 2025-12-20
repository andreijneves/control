# Sistema Control - Agendamento de Serviços

## 📋 Descrição

Sistema completo de agendamento de serviços desenvolvido com **Yii2 Framework**, **MySQL** e **Bootstrap 5**. Totalmente em **Português (pt-BR)**.

## ✨ Funcionalidades Implementadas

### 🏠 Módulo SITE (Área Pública)
- **Página Inicial**: Informações gerais do sistema
- **Cadastro de Empresa**: Permite que empresas se registrem na plataforma
- **Login**: Autenticação de usuários
- **Página Sobre**: Informações sobre o sistema
- **Página de Contato**: Formulário de contato

### 👨‍💼 Módulo ADMIN GERAL
- **Dashboard**: Visão geral com estatísticas
- **Gerenciamento de Empresas**: CRUD completo
  - Criar empresa
  - Editar empresa
  - Deletar empresa
  - Listar empresas
- **Estatísticas**: Total de empresas, usuários, funcionários e serviços

### 🏢 Módulo ADMIN EMPRESA
- **Dashboard**: Painel com estatísticas da empresa
- **Gerenciamento de Serviços**
  - Criar serviço
  - Editar serviço
  - Deletar serviço
  - Listar serviços com preço e duração
- **Gerenciamento de Funcionários**
  - Criar funcionário
  - Editar funcionário
  - **Configurar Horários Disponíveis**: Definir horários por dia da semana
  - Listar funcionários
- **Gerenciamento de Clientes**
  - Criar cliente
  - Editar cliente
  - Listar clientes
- **Gerenciamento de Agendamentos**
  - Confirmar agendamentos
  - Cancelar agendamentos
  - Visualizar status dos agendamentos

### 👥 Módulo ÁREA PÚBLICA DA EMPRESA (Cliente)
- **Dashboard do Cliente**
  - Visualizar empresa
  - Ver histórico de agendamentos
  - Visualizar status dos agendamentos
- **Cadastro como Cliente**
  - Completar perfil na empresa
  - Informações pessoais
- **Agendamento de Serviços**
  - Selecionar serviço
  - Escolher funcionário
  - Definir data e hora
  - Adicionar observações

## 🗄️ Banco de Dados

### Tabelas Principais
- **usuario**: Usuários do sistema (admin_geral, admin_empresa, funcionario, cliente)
- **empresa**: Empresas cadastradas
- **funcionario**: Funcionários das empresas
- **servico**: Serviços oferecidos
- **cliente**: Clientes das empresas
- **horario**: Horários disponíveis dos funcionários
- **agendamento**: Agendamentos de serviços

## 🔐 Sistema de Permissões

### Roles (Funções)
1. **admin_geral**: Administrador do sistema
   - Acesso a: Admin Geral
   - Dashboard com estatísticas globais

2. **admin_empresa**: Administrador da empresa
   - Acesso a: Admin Empresa
   - Gerenciamento completo da empresa

3. **funcionario**: Funcionário
   - Visualizar agendamentos
   - Gerenciar horários

4. **cliente**: Cliente
   - Visualizar empresa
   - Agendar serviços

## 🚀 Como Usar

### Iniciar o Sistema

```bash
cd /home/andrei/Área\ de\ trabalho/html/control
./yii serve  # ou
php -S localhost:8000 -t web/
```

### Credenciais de Teste

```
Admin Geral:
  Usuário: admin
  Senha: admin123

Admin Empresa:
  Usuário: empresa_admin
  Senha: empresa123
```

## 📁 Estrutura de Pastas

```
control/
├── config/              # Configurações
├── controllers/         # Controladores
│   ├── SiteController.php
│   ├── AdminController.php
│   ├── EmpresaController.php
│   └── ClienteController.php
├── models/             # Modelos
│   ├── Usuario.php
│   ├── Empresa.php
│   ├── Funcionario.php
│   ├── Servico.php
│   ├── Cliente.php
│   ├── Horario.php
│   ├── Agendamento.php
│   ├── LoginForm.php
│   └── ContactForm.php
├── views/              # Views (Vistas)
│   ├── layouts/
│   │   └── main.php
│   ├── site/
│   ├── admin/
│   ├── empresa/
│   └── cliente/
├── migrations/         # Migrations do banco
├── commands/           # Comandos console
├── web/               # Público (index.php)
├── vendor/            # Dependências Composer
└── yii               # Arquivo executável
```

## 🛠️ Tecnologias Utilizadas

- **PHP 7.4+**
- **Yii2 Framework**
- **MySQL 5.7+**
- **Bootstrap 5**
- **Composer**

## 📝 Fluxos Principais

### 1. Cadastro de Empresa
1. Visitante acessa `/site/cadastro-empresa`
2. Preenche dados da empresa
3. Sistema cria usuário admin_empresa automaticamente
4. Usuário faz login com credenciais

### 2. Gerenciamento de Empresa
1. Admin da empresa acessa dashboard
2. Cria serviços, funcionários e clientes
3. Configura horários dos funcionários
4. Gerencia agendamentos

### 3. Agendamento de Cliente
1. Cliente se cadastra na empresa
2. Acessa área do cliente
3. Seleciona serviço, funcionário e data
4. Solicita agendamento
5. Admin confirma ou cancela

## 🔧 Comandos Úteis

```bash
# Executar migrations
./yii migrate

# Inicializar dados de teste
./yii init/index

# Iniciar servidor de desenvolvimento
php -S localhost:8000 -t web/

# Executar tests
./yii test
```

## 📧 Contato

Desenvolvido conforme especificação no arquivo `promt.txt`.

---

**Versão**: 1.0  
**Data**: 19 de Dezembro de 2025  
**Status**: ✅ Completo e Funcional
