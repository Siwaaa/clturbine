```
cd www/clturbine.ru/
```

Заменить строки в .env
```
APP_NAME=Clturbine
APP_ENV=production
APP_KEY=base64:wNFrbQ1syy67/RQNxvA3k8WmrJ/+SYq4iC3BhxX91pQ=
APP_DEBUG=true
APP_URL=https://clturbine.site
```

```
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

```
npm run prod
rm /bootstrap/cache/config.php
```
