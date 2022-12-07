## Framework 
```
реализуется на паттерне MVC
```

## Тестируется
```
 через PhpUnit и PhpStan
 ```
 
## Что реализовано
```
-рутеры (на манер ларавел)
-контроллеры
-модели
-миграция с версиями (для отката и наката), рандомное заполнение данных
-сбор страницы
```

## техническое
```
Запуск миграций
php migration.php -r:Migrate 

Откат миграций
php migration.php -r:Down

PhpStan
php vendor\phpstan\phpstan\phpstan analyse core
```
