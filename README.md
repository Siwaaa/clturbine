
## Deployment
1. Локально проделываем следующие операции:
```
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run prod
```
2. Пуляем на github
```
git add .
git commit -m ""
git push origin master
```

На хостинге
3. Подтянуть изменения
```
cd www/clturbine.ru/
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

