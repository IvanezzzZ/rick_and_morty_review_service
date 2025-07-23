Инструкция по разворачиванию проекта:

1. запустить контейнеры: make up
2. Зайти в контейнер с php: make cli
   И внутри него попорядку выполнить следующие команды:
2.1 composer install
2.2 php artisan migrate
2.3 php artisan sync:episodes
2.4 php artisan db:seed
2.5 php artisan test
2.6 php artisan l5:g

Swagger -документация доступна по адресу:
http://localhost:8989/api/documentation
