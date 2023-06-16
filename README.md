# Тестове завдання від ITS
[Лінк на ТЗ](https://drive.google.com/file/d/1bNgfzxfNXQF-m8s82fLAWWREof69UWKz/view)

## Вимоги до системи

1. composer
2. nodejs `v16.12.0`
3. npm `v8.1.0`
4. php `>=8.0.2`
5. БД

## Встановлення
1. Створити телеграм бот. В ботфазер через команду `/setdomain` встановити домен сайту. ***Обов'язково підтримка https***.
2. Скопіювати файл `.env.example` в `.env`.
3. В створеному файлі `.env` налаштувати:
   * База данних (префікс `DB_`)
   * Сервіс розсилки (префікс `MAIL_`)
   * Встановити токен телеграм бота `TELEGRAM_BOT_TOKEN`
   * Вказати нік телеграм бота в `VITE_TELEGRAM_BOT_NAME`, без `@`
4. Виконати `composer install`.
5. Виконати `php artisan key:generate`.
6. Виконати `php artisan jwt:secret`
7. Виконати `php artisan migrate`.
8. Виконати `php artisan db:seed`.
9. Виконати `npm install`.
10. Виконати `npm run build`.


## Додатково
1. Створити щохвилинний крон `php artisan schedule:work`
2. Запустити чергу `php artisan queue:work --queue=event,reminder,default --tries=3`

Приємного тестування
