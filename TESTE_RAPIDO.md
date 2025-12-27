# 🚀 GUIA DE TESTE RÁPIDO - SISTEMA CONTROL

## ✅ Sistema Totalmente Reconstruído do Zero

O sistema **Control** foi completamente refaçado conforme o prompt.txt com todas as funcionalidades implementadas.

---

## 📋 Checklist de Implementação

### Configurações Base ✅
- [x] PHP com Yii2 Framework
- [x] MySQL como banco de dados
- [x] Bootstrap 5 para frontend
- [x] Tudo em Português (pt-BR)
- [x] Modelo Yii Basic

### Módulo SITE ✅
- [x] Página inicial com informações
- [x] Cadastro de empresa
- [x] Login
- [x] Página Sobre
- [x] Página de Contato

### Módulo ADMIN GERAL ✅
- [x] Dashboard com estatísticas
- [x] Gerenciamento de empresas (CRUD)
- [x] Visualização de dados globais

### Módulo ADMIN EMPRESA ✅
- [x] Dashboard da empresa
- [x] **Cadastro de Serviços** com preço e duração
- [x] **Cadastro de Funcionários** com usuários e senhas automáticas
- [x] **Configuração de Horários Disponíveis** por dia da semana
- [x] **Cadastro de Clientes**
- [x] **Agendamento de Serviços** para funcionários
- [x] Confirmação e cancelamento de agendamentos

### Módulo ÁREA PÚBLICA DA EMPRESA ✅
- [x] Dashboard simples para cliente
- [x] Cadastro de cliente na empresa
- [x] Solicitação de agendamento de serviço
- [x] Visualização de agendamentos

---

## 🧪 Como Testar

### 1. Acessar o Sistema
```bash
# Inicie o servidor (já está rodando em localhost:8000)
# Ou acesse via: http://localhost:8000
```

### 2. Testar como Admin Geral
- **URL**: http://localhost:8000
- **Login**: `admin` / `admin123`
- **Ações**:
  - Ver dashboard com estatísticas
  - Gerenciar empresas (criar, editar, deletar)

### 3. Testar como Admin Empresa
- **Login**: `empresa_admin` / `empresa123`
- **Ações**:
  - Ver dashboard da empresa
  - Criar serviço (nome, descrição, preço, duração)
  - Criar funcionário (nome, CPF, email, cargo)
  - Configurar horários do funcionário (dia/hora)
  - Criar cliente
  - Visualizar agendamentos

### 4. Testar como Cliente
1. Vá para `/site/cadastro-empresa`
2. Cadastre uma nova empresa
3. Você receberá credenciais de admin_empresa
4. Entre no sistema como admin e crie alguns dados
5. Crie um usuário cliente na empresa
6. Faça login como cliente
7. Complete o cadastro de cliente
8. Agende um serviço

---

## 📊 Banco de Dados

O banco foi totalmente recriado com as seguintes tabelas:
- `usuario` - Usuários do sistema
- `empresa` - Empresas cadastradas
- `funcionario` - Funcionários
- `servico` - Serviços oferecidos
- `cliente` - Clientes da empresa
- `horario` - Horários disponíveis
- `agendamento` - Agendamentos realizados

**Status**: ✅ Migrations executadas com sucesso

---

## 🔑 Credenciais de Teste Criadas

```
🔐 Admin Geral:
   Usuário: admin
   Senha: admin123
   Empresa: Nenhuma

🔐 Admin Empresa:
   Usuário: empresa_admin
   Senha: empresa123
   Empresa: Empresa Teste (ID: 1)
```

---

## 📱 Fluxos Principais

### Fluxo 1: Cadastro de Empresa
1. Visitante acessa homepage
2. Clica em "Cadastrar Empresa"
3. Preenche dados (nome, CNPJ, email, etc.)
4. Define responsável e senha
5. Sistema cria usuario admin_empresa
6. Redireciona para login

### Fluxo 2: Gerenciar Empresa
1. Admin da empresa faz login
2. Acessa dashboard
3. Cria serviços (nome, preço, duração)
4. Cria funcionários
5. Configura horários por dia da semana
6. Cria clientes
7. Gerencia agendamentos (confirmar/cancelar)

### Fluxo 3: Cliente Agendar Serviço
1. Cliente se cadastra na empresa
2. Acessa seu painel
3. Clica em "Agendar Serviço"
4. Seleciona serviço
5. Escolhe funcionário
6. Define data e hora
7. Submete solicitação
8. Status aparece como "Pendente"
9. Admin confirma ou cancela

---

## 🎯 Rotas Principais

| Rota | Descrição | Acesso |
|------|-----------|--------|
| `/` | Homepage | Público |
| `/site/login` | Login | Público |
| `/site/cadastro-empresa` | Cadastro empresa | Público |
| `/site/sobre` | Sobre | Público |
| `/site/contato` | Contato | Público |
| `/admin/index` | Dashboard Admin | Admin Geral |
| `/admin/empresas` | Gerenciar empresas | Admin Geral |
| `/empresa/index` | Dashboard Empresa | Admin Empresa |
| `/empresa/servicos` | Gerenciar serviços | Admin Empresa |
| `/empresa/funcionarios` | Gerenciar funcionários | Admin Empresa |
| `/empresa/configurar-horarios` | Configurar horários | Admin Empresa |
| `/empresa/clientes` | Gerenciar clientes | Admin Empresa |
| `/empresa/agendamentos` | Gerenciar agendamentos | Admin Empresa |
| `/cliente/index` | Painel cliente | Cliente |
| `/cliente/cadastrar` | Cadastro cliente | Cliente |
| `/cliente/agendar` | Agendar serviço | Cliente |

---

## ✨ Características Especiais

1. **Autenticação Segura**: Senhas criptografadas com hash
2. **Controle de Acesso**: Roles (admin_geral, admin_empresa, funcionario, cliente)
3. **Interface Responsiva**: Bootstrap 5
4. **Banco de Dados Normalizado**: Relacionamentos corretos com FKs
5. **Timestamps Automáticos**: created_at e updated_at em todas as tabelas
6. **Sistema de Status**: Agendamentos com status (pendente, confirmado, cancelado, concluído)

---

## 🐛 Troubleshooting

Se encontrar problemas:

1. **Erro de conexão com banco**:
   ```bash
   mysql -u dev -psenha -e "SHOW DATABASES;" | grep control
   ```

2. **Migrations não rodadas**:
   ```bash
   ./yii migrate --interactive=0
   ```

3. **Dados de teste não criados**:
   ```bash
   ./yii init/index
   ```

4. **Servidor PHP não iniciando**:
   ```bash
   cd /home/andrei/Área\ de\ trabalho/html/control/web
   php -S localhost:8000
   ```

---

## 📝 Notas Importantes

- ✅ Sistema totalmente em **Português (pt-BR)**
- ✅ Interface **intuitiva e responsiva**
- ✅ Banco de dados **otimizado com índices**
- ✅ **4 módulos distintos** com layouts próprios
- ✅ Funcionalidades **completas conforme prompt**
- ✅ **Pronto para produção** (com ajustes de segurança)

---

**Sistema Completo e Funcional! 🎉**

Desenvolvido em: 19 de Dezembro de 2025
