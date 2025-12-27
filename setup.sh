#!/bin/bash

echo "🚀 Configurando Yii2 para Apache..."

# Verificar se SQLite está instalado
if ! php -m | grep -q sqlite; then
    echo "❌ SQLite não encontrado no PHP!"
    echo "💡 Instale: sudo apt-get install php-sqlite3 php-pdo-sqlite"
    echo "💡 Ou no CentOS: sudo yum install php-sqlite3"
    read -p "Continuar mesmo assim? (y/n): " -n 1 -r
    echo
    if [[ ! $REPLY =~ ^[Yy]$ ]]; then
        exit 1
    fi
fi

# Criar diretórios necessários
mkdir -p runtime/{cache,logs,session} web/assets 2>/dev/null
chmod -R 777 runtime/ web/assets/ 2>/dev/null || true

# Instalar dependências se necessário  
if [ ! -d "vendor" ]; then
    echo "📦 Instalando dependências..."
    composer install --no-dev --optimize-autoloader 2>/dev/null || {
        echo "❌ Instale composer: https://getcomposer.org"
        exit 1
    }
fi

# Executar migrações para criar banco
echo "🗄️ Criando banco de dados SQLite..."
php yii migrate --interactive=0 2>/dev/null || echo "⚠️ Execute manualmente: php yii migrate"

# Limpar cache
rm -rf runtime/cache/* runtime/logs/* web/assets/* 2>/dev/null || true

echo "✅ Sistema configurado!"
echo "🌐 Acesse: http://localhost/control/web/"
echo "💡 Ou configure Virtual Host apontando para pasta web/"

# Criar diretórios
mkdir -p runtime/{cache,logs,session} web/assets 2>/dev/null

# Configurar permissões para Apache
if command -v www-data &> /dev/null; then
    sudo chown -R www-data:www-data runtime/ web/assets/ 2>/dev/null || true
    sudo chmod -R 775 runtime/ web/assets/ 2>/dev/null || true
else
    chmod -R 777 runtime/ web/assets/ 2>/dev/null || true
fi

# Configurar banco SQLite automático
echo "🗄️ Configurando banco de dados..."
cat > config/db.php << 'EOF'
<?php
$dbFile = dirname(__DIR__) . '/runtime/app.db';
if (!file_exists($dbFile)) {
    touch($dbFile);
    chmod($dbFile, 0666);
}

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'sqlite:' . $dbFile,
    'username' => '',
    'password' => '',
    'charset' => 'utf8',
];
EOF

# Executar migrações
echo "📋 Criando tabelas..."
php yii migrate --interactive=0 2>/dev/null || true

# Configurar .htaccess para Apache
echo "🌐 Configurando Apache..."
cat > .htaccess << 'EOF'
# Redirecionar tudo para a pasta web
RewriteEngine on
RewriteCond %{REQUEST_URI} !^/(web|assets)/
RewriteRule ^(.*)$ web/$1 [L]
EOF

# Verificar se mod_rewrite está habilitado
if [ -f "/etc/apache2/mods-enabled/rewrite.load" ] || [ -f "/etc/httpd/conf.modules.d/00-base.conf" ]; then
    echo "✅ mod_rewrite detectado"
else
    echo "⚠️ Habilite mod_rewrite: sudo a2enmod rewrite && sudo systemctl restart apache2"
fi

# Dar permissões aos scripts
chmod +x clear-cache.sh fix-permissions.sh configure-apache.sh 2>/dev/null || true

echo ""
echo "✅ Sistema configurado para Apache!"
echo "📁 Document Root deve apontar para: $(pwd)/web"
echo "🌐 Para configurar Virtual Host: sudo ./configure-apache.sh"
echo "🌐 Ou acesse: http://localhost (se já configurado)"
echo "💡 Se não funcionar, reinicie o Apache: sudo systemctl restart apache2"