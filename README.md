## Products

1) Перейдите в корень приложения и скачайте все зависимости:
```bash
composer install
```

2) Чтобы запустить приложение наберите команду из корня приложения:
```bash
vendor/bin/sail up -d
```

3) Запустить миграции
```bash
vendor/bin/sail artisan migrate
```

4) Заполнить таблицу products в базе данных   
из АПИ https://dummyjson.com/docs/products
```bash
vendor/bin/sail artisan db:seed
```

# Доступные ручки
1) Get all products -> [GET]localhost/api/products 
2) Get products by category -> [GET]localhost/api/products/category/{id}
3) Get all product categories -> [GET]localhost/api/products/categories
4) Show product -> [GET]localhost/api/products/{id}
5) Search products -> [GET]localhost/api/products/search/{q}
6) Create product -> [POST]localhost/api/product

