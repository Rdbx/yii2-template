# Базовый проект

Требуется node.js 14+, php 8.1+

[![build](https://github.com/yiisoft/yii2-app-advanced/workflows/build/badge.svg)](https://github.com/yiisoft/yii2-app-advanced/actions?query=workflow%3Abuild)

## Установка

### API

#### Создать файл в папке backend auth.json
```json
{
    "gitlab-token": {
        "git.rdbx24.ru": {
            "username": "{{gitlab+deploy-token}}",
            "token": "{{gitlab+deploy-token-password}}"
        }
    }
}
```

#### Настроить переменные окружения
1) Скопировать `.env.example`
2) Переименовать скопированный файл в `.env`
3) Настроить работу с базой данных


#### Выполнить команды по очереди
```sh
cd ./backend
openssl genrsa -out private.pem 2048
openssl rsa -in private.pem -pubout -out public.pem
composer install
php yii serve --docroot="api/web"
```

### Frontend
#### Выполнить команды по очереди
```sh
cd ./frontend
npm install
npm run dev
```
