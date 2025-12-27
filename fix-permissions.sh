#!/bin/bash

# Script para corrigir permissões no ambiente de produção/homologação
# Execute após deploy inicial ou quando houver problemas de permissão

echo "🔧 Corrigindo permissões para aplicação Yii2..."

# Detectar usuário do web server
WEB_USER="www-data"
if id -u apache &>/dev/null; then
    WEB_USER="apache"
elif id -u nginx &>/dev/null; then
    WEB_USER="nginx"
fi

echo "📁 Usuário do web server detectado: $WEB_USER"

# Verificar se precisa de sudo
if [[ $EUID -ne 0 ]]; then
    echo "⚠️  Este script precisa ser executado com sudo para alterar permissões"
    echo "Executando: sudo $0"
    sudo "$0" "$@"
    exit $?
fi

echo "1. Configurando permissões do diretório runtime..."
chown -R $WEB_USER:$WEB_USER runtime/
chmod -R 775 runtime/
chmod g+s runtime/

echo "2. Configurando permissões do diretório web/assets..."
chown -R $WEB_USER:$WEB_USER web/assets/
chmod -R 775 web/assets/
chmod g+s web/assets/

echo "3. Criando diretórios necessários se não existirem..."
mkdir -p runtime/{cache,logs,session,debug} 2>/dev/null
mkdir -p web/assets 2>/dev/null

echo "4. Aplicando permissões finais..."
chown -R $WEB_USER:$WEB_USER runtime/ web/assets/
chmod -R 775 runtime/ web/assets/

echo "5. Verificando resultado..."
ls -la runtime/ | head -3
ls -la web/assets/ | head -3

echo "✅ Permissões configuradas com sucesso!"
echo "📋 Resumo:"
echo "   - Diretório runtime: propriedade $WEB_USER, permissões 775"
echo "   - Diretório assets: propriedade $WEB_USER, permissões 775"
echo "   - Bit setgid ativado para herdar grupo automaticamente"
echo ""
echo "💡 Para testar: php yii clear-cache ou ./clear-cache.sh"