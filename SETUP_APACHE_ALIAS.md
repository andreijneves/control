# 🚀 Configurar Apache para Acessar em http://localhost/control/web

## Opção 1: Alias do Apache (Recomendado - Sem VirtualHost)

### Passo 1: Copiar a configuração
```bash
sudo cp "/home/andrei/Área de trabalho/html/control/apache-alias.conf" /etc/apache2/conf-available/control-alias.conf
```

### Passo 2: Habilitar módulos
```bash
sudo a2enmod rewrite
sudo a2enmod alias
sudo a2enmod headers
```

### Passo 3: Habilitar a configuração
```bash
sudo a2enconf control-alias
```

### Passo 4: Testar
```bash
sudo apache2ctl configtest
```

### Passo 5: Reiniciar Apache
```bash
sudo systemctl restart apache2
```

### Passo 6: Acessar
```
http://localhost/control/web
```

---

## Opção 2: Link Simbólico (Alternativa)

Se preferir criar um link simbólico no DocumentRoot padrão:

```bash
sudo ln -s "/home/andrei/Área de trabalho/html/control/web" /var/www/html/control
```

Depois acesse em:
```
http://localhost/control
```

---

## Opção 3: PHP Built-in Server (Se Apache não estiver disponível)

```bash
cd "/home/andrei/Área de trabalho/html/control"
php -S localhost:8000 -t web/
```

Acesse em:
```
http://localhost:8000
```

---

## ✅ Qual usar?

- **Opção 1 (Recomendada)**: Usa Apache real, melhor para produção
- **Opção 2**: Mais simples, requer DocumentRoot /var/www/html
- **Opção 3**: Melhor para desenvolvimento rápido
