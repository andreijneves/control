#!/bin/bash

# Script para limpar cache e assets no ambiente de homologação
# Use este script após fazer git pull para garantir que as alterações apareçam

echo "🧹 Limpando caches do projeto..."

# Verificar se precisa de sudo
if [[ ! -w runtime/ ]] || [[ ! -w web/assets/ ]]; then
    echo "⚠️  Permissões restritivas detectadas. Pode ser necessário sudo."
    USE_SUDO="sudo"
else
    USE_SUDO=""
fi

# Limpar cache do Yii2
echo "1. Limpando cache do runtime..."
$USE_SUDO find runtime/cache -type f -delete 2>/dev/null || true
$USE_SUDO find runtime/HTML -type f -delete 2>/dev/null || true
$USE_SUDO find runtime/debug -name "*.data" -delete 2>/dev/null || true

# Limpar assets compilados
echo "2. Limpando assets compilados..."
$USE_SUDO find web/assets -mindepth 1 -not -name '.gitignore' -delete 2>/dev/null || true

# Limpar logs antigos (opcional)
echo "3. Limpando logs antigos..."
$USE_SUDO find runtime/logs -name "*.log" -delete 2>/dev/null || true

# Dar permissões corretas (apenas se necessário)
if [[ -n "$USE_SUDO" ]]; then
    echo "4. Ajustando permissões..."
    $USE_SUDO chown -R www-data:www-data runtime/ web/assets/ 2>/dev/null || true
    $USE_SUDO chmod -R 775 runtime/ web/assets/ 2>/dev/null || true
fi

echo "✅ Cache limpo! Agora acesse o site para regenerar os assets."
echo "💡 Dicas:"
echo "   - Faça Ctrl+F5 no navegador para limpar cache do browser"
echo "   - Se usar Apache/Nginx, reinicie o serviço se necessário"
echo "   - No ambiente de produção, use: php yii clear-cache"