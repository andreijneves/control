#!/bin/bash

# Script para configurar Apache para servir o projeto Control na porta 80

echo "=== Configurando Apache para Control ==="

# Criar .htaccess no diretório web
cat > /home/andrei/Área\ de\ trabalho/html/control/web/.htaccess << 'EOF'
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /
    
    # Se não for um arquivo existente
    RewriteCond %{REQUEST_FILENAME} !-f
    # Se não for um diretório existente
    RewriteCond %{REQUEST_FILENAME} !-d
    
    # Reescrever para index.php
    RewriteRule ^(.*)$ index.php?%{QUERY_STRING} [L]
</IfModule>
EOF

echo "✓ .htaccess criado"

# Habilitar módulos necessários
echo "Habilitando módulos Apache..."
sudo a2enmod rewrite 2>/dev/null && echo "✓ mod_rewrite habilitado" || echo "⚠ mod_rewrite já estava habilitado"
sudo a2enmod headers 2>/dev/null && echo "✓ mod_headers habilitado" || echo "⚠ mod_headers já estava habilitado"

# Copiar configuração para sites-available
echo "Copiando configuração para Apache..."
sudo cp /home/andrei/Área\ de\ trabalho/html/control/apache-control.conf /etc/apache2/sites-available/control.conf 2>/dev/null

# Habilitar o site
echo "Habilitando site..."
sudo a2ensite control 2>/dev/null && echo "✓ Site habilitado" || echo "ℹ Site já estava habilitado"

# Testar sintaxe
echo ""
echo "Testando sintaxe Apache..."
sudo apache2ctl configtest

echo ""
echo "=== Para ativar as mudanças, execute: ==="
echo "sudo systemctl restart apache2"
echo ""
echo "=== Adicione ao /etc/hosts: ==="
echo "127.0.0.1 control.local"
echo ""
echo "=== Acesse em: ==="
echo "http://control.local"
