# Тестовое задание

<p>Сделано на yii2 advanced template</p>

<p>Фронтенд находится в папке frontend, бэкенд - в папке backend, скрипт импорта - в папке console</p>
<p>Отправка почты сделана через mailtrap.io</p>

## Подготовка

<p>Загружаемык картинки сохраняются в папке бэкенда. Чтобы они отображались на бэкенде нужно в common/config/params-local.php добавить путь до бэкенда, например:</p>

```php
return [
    'frontendUrl' => 'http://backend/'
];
```

## Импорт книг из файла

<p>Запустить php yii import/start</p>
