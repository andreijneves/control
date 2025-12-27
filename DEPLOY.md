# 🚀 Deploy e Cache - Ambiente de Homologação

## 🎯 Problema Comum
**Situação**: Após fazer `git pull`, as alterações de layout não aparecem no ambiente de homologação.

**Causa**: Cache de assets compilados do Yii2 não é automaticamente regenerado.

## 🛠️ Soluções (em ordem de preferência)

### 1️⃣ **Script Automático (Recomendado)**
```bash
# No servidor de homologação, após git pull:
./clear-cache.sh
```

### 2️⃣ **Comando Yii2 Console**
```bash
# Limpar tudo
php yii clear-cache

# Ou limpar apenas assets
php yii clear-cache/assets
```

### 3️⃣ **Limpeza Manual Rápida**
```bash
# Assets e runtime
sudo rm -rf web/assets/* runtime/cache/* runtime/HTML/*
sudo chown -R www-data:www-data web/assets/ runtime/
sudo chmod -R 775 web/assets/ runtime/
```

### 4️⃣ **Corrigir Permissões (se necessário)**
```bash
# Script automático para permissões
./fix-permissions.sh

# Ou comando direto
sudo chown -R www-data:www-data web/assets/ runtime/
sudo chmod -R 775 web/assets/ runtime/
```

## 🔄 **Fluxo Completo de Deploy**

```bash
# 1. Backup (se necessário)
cp -r web/assets web/assets.bak

# 2. Atualizar código
git pull origin master

# 3. Dependências (se composer.lock mudou)
composer install --no-dev --optimize-autoloader

# 4. Limpar cache (ESSENCIAL)
./clear-cache.sh

# 5. Migrações de BD (se houver)
php yii migrate --interactive=0

# 6. Verificar se funciona
curl -I http://localhost/seu-projeto
```

## 🌐 **Cache do Navegador**

**Sempre limpe o cache do navegador após deploy:**
- **Chrome/Edge**: `Ctrl + Shift + R` ou `F12 → Network → Disable cache`
- **Firefox**: `Ctrl + Shift + R` 
- **Safari**: `Cmd + Option + R`

## ⚡ **Soluções Rápidas por Problema**

### 🔴 Assets não atualizam
```bash
rm -rf web/assets/* && php yii asset/compress
```

### 🔴 CSS/JS não carrega
```bash
# Verificar se assets existem
ls -la web/assets/
# Se vazio, acesse qualquer página do site para gerar
```

### 🔴 Erro 500 após deploy
```bash
# Verificar logs
tail -f runtime/logs/app.log
# Verificar permissões
ls -la runtime/ web/assets/
```

### 🔴 Cache "grudado"
```bash
# Forçar timestamp diferente
touch web/css/site.css web/js/site-effects.js
./clear-cache.sh
```

## 🚨 **Troubleshooting Avançado**

### **Erro: "Directory is not writable"**
```bash
# Solução rápida
./fix-permissions.sh

# Ou manual
sudo chown -R www-data:www-data web/assets/ runtime/
sudo chmod -R 775 web/assets/ runtime/
sudo chmod g+s web/assets/ runtime/
```

### **Assets regeneram mas são iguais**
O Yii2 usa hash MD5 dos arquivos. Se o conteúdo não mudou, o hash será igual.

**Solução**: Force mudança no arquivo fonte:
```bash
# Adicione comentário com timestamp
echo "/* Updated $(date) */" >> web/css/site.css
```

### **Permissões complexas**
```bash
# Resetar tudo
sudo chown -R $USER:www-data runtime/ web/assets/
sudo chmod -R 775 runtime/ web/assets/
sudo chmod g+s runtime/ web/assets/
```

### **Cache persistente**
```bash
# Desabilitar cache temporariamente
# No config/web.php, adicione:
# 'assetManager' => [
#     'forceCopy' => true,
# ],
```

## 🔧 **Configuração de Produção**

### **Apache .htaccess** (se necessário)
```apache
# Em web/.htaccess, adicionar:
<IfModule mod_expires.c>
    ExpiresActive on
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
</IfModule>
```

### **Nginx** (se necessário)
```nginx
location ~* \.(css|js)$ {
    expires 1M;
    add_header Cache-Control "public, immutable";
}
```

## 📋 **Checklist Rápido**

- [ ] `git pull` executado
- [ ] `./clear-cache.sh` executado 
- [ ] Permissões OK (`ls -la web/assets runtime`)
- [ ] Cache do navegador limpo (`Ctrl+Shift+R`)
- [ ] Teste em navegador anônimo/privado
- [ ] Logs verificados (`tail runtime/logs/app.log`)

---
**💡 Dica**: Salve este arquivo como favorito para consulta rápida!