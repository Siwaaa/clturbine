
## Deployment
1. Локально проделываем следующие операции:
Меняем api url на public
```sh
npm run prod
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
```
1. Пуляем на github
```sh
git add .
git commit -m ""
git push origin master
```

## На vps
3. Подтянуть изменения
```
cd /var/www/www-root/data/www/clturbine.site
git pull
```
Если есть изменения:
```
git checkout ИМЯ_ФАЙЛА
```

4. Заменить строки в .env
```
cp -f .env.example .env
```


