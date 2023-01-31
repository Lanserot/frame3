## Framework 
```
Реализуется на паттерне MVC
Всё своим умом, максимум могу подсмотреть как реализовано у других.
Например: у ларавель рутеры задаются через Route::get().
Этого вполне достаточно (С)

Часто я дополняю разные фичи и правклю то, что подходит под "TODO:ИСПРАВИТЬ"
```

## Тестируется
```
 через PhpUnit и PhpStan, собственные методы
 ```
 
## Что реализовано
```
-передача переменных через @@ из тела в header, по типу ларавель 
Header @title@
Body @title=Список пользователей@
В итоге в header у наз заголовок установленный через код предназначенный для тела

-рутеры (на манер ларавел, различия POST и GET методы, Started to implement "Middleware")
пример : Route::get('test', 'TestController@testMethod')->name('test-page');

-контроллеры (redirect, render)

-модели(find, getLimit)

-миграция с версиями (для отката и наката), рандомное заполнение данных

-сбор страницы

-error handler like laravel
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
