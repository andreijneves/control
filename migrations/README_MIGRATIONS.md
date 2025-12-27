# 🚀 Sistema de Controle de Agendamentos - Migrations

## 📋 Descrição
Migrations atualizadas do sistema completo de controle de agendamentos criado em 21/12/2025.

## 🗃️ Estrutura do Banco de Dados

### Tabelas Principais:
- **empresa** - Empresas cadastradas (clientes do sistema)
- **usuario** - Usuários com diferentes roles (admin, admin_empresa, funcionario, cliente)
- **funcionario** - Funcionários das empresas
- **servico** - Serviços oferecidos pelas empresas
- **cliente** - Clientes das empresas
- **horario** - Horários de funcionamento (geral e por funcionário)
- **agendamento** - Agendamentos realizados

## 🔧 Como Usar

### 1. Primeira Instalação
```bash
# Navegar para o diretório do projeto
cd /home/andrei/Área\ de\ trabalho/html/control

# Executar as migrations
php yii migrate

# Aplicar as novas migrations
php yii migrate --migrationPath=@app/migrations
```

### 2. Reset Completo (CUIDADO: APAGA TODOS OS DADOS)
```bash
# Reverter todas as migrations antigas
php yii migrate/down all

# Aplicar as novas migrations
php yii migrate
```

### 3. Verificar Status
```bash
# Ver migrations aplicadas
php yii migrate/history

# Ver migrations pendentes
php yii migrate/new
```

## 👥 Usuários Criados

### Admin Geral
- **Usuário:** admin
- **Senha:** admin123
- **Email:** admin@sistema.com
- **Acesso:** Gerenciamento completo do sistema

### Admin da Empresa Exemplo
- **Usuário:** salao-beleza-total_admin
- **Senha:** 123456
- **Email:** contato@belezatotal.com
- **Empresa:** Salão Beleza Total

## 🏢 Dados de Exemplo Criados

### Empresa: Salão Beleza Total
- **CNPJ:** 12.345.678/0001-90
- **Telefone:** (11) 99999-9999
- **Responsável:** Maria Silva

### Funcionários (3):
1. Ana Costa - Especialista em corte feminino
2. Carlos Souza - Especialista em corte masculino  
3. Juliana Santos - Manicure e pedicure

### Serviços (7):
- Corte Feminino (R$ 45,00)
- Corte Masculino (R$ 25,00)
- Coloração Completa (R$ 120,00)
- Hidratação Capilar (R$ 60,00)
- Manicure (R$ 20,00)
- Pedicure (R$ 25,00)
- Barba Completa (R$ 15,00)

### Clientes (5):
- João Silva, Maria Oliveira, Pedro Santos, Ana Costa, Carlos Ferreira

### Horários de Funcionamento:
- **Segunda a Sexta:** 08:00 às 18:00
- **Sábado:** 08:00 às 14:00
- **Domingo:** Fechado

## 🔑 Principais Recursos

### Relacionamentos com CASCADE:
- Ao deletar empresa → Remove todos funcionários, serviços, clientes, agendamentos
- Ao deletar funcionário → Remove seus horários e agendamentos
- Ao deletar cliente → Remove seus agendamentos

### Índices de Performance:
- Consultas otimizadas por empresa, data, status
- Busca rápida por email e telefone
- Consultas eficientes de agendamentos

### Roles de Usuário:
- **admin:** Controle total do sistema
- **admin_empresa:** Gerencia uma empresa específica
- **funcionario:** Acesso limitado aos seus agendamentos
- **cliente:** Visualiza apenas seus próprios agendamentos

## 🛡️ Segurança

### Chaves Estrangeiras:
- Integridade referencial garantida
- Prevenção de dados órfãos
- Exclusão em cascata controlada

### Validações:
- Emails únicos por empresa
- CNPJs únicos no sistema
- Usernames únicos globalmente

## 📱 Funcionalidades do Sistema

### Área Pública:
- Cada empresa tem sua área pública isolada
- Clientes podem se cadastrar e agendar
- Layout personalizado por empresa

### Admin Geral:
- Gerenciamento completo de empresas
- Controle de usuários
- Exclusão em cascata segura

### Admin da Empresa:
- Gestão de funcionários e serviços
- Controle de agendamentos
- Configuração de horários

### Características Especiais:
- Sistema multi-tenant (cada empresa isolada)
- Interface responsiva com Bootstrap 5
- Proteção CSRF configurada
- Logs de auditoria implementados

## 🔄 Comandos Úteis

```bash
# Backup do banco antes das migrations
mysqldump -u root -p nome_do_banco > backup_antes_migration.sql

# Aplicar migration específica
php yii migrate/to 251221_000001

# Ver SQL que será executado
php yii migrate --dry-run

# Forçar aplicação (não recomendado em produção)
php yii migrate --compact=1
```

## ⚠️ IMPORTANTE

1. **Sempre faça backup** antes de executar migrations em produção
2. **Teste em ambiente de desenvolvimento** primeiro
3. **Verifique as dependências** do Yii2 antes de executar
4. **Altere as senhas padrão** em produção

---

**Sistema criado em:** 21 de dezembro de 2025  
**Framework:** Yii2 + Bootstrap 5  
**Banco:** MySQL/MariaDB  
**Status:** Produção Ready ✅