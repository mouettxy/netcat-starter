# NetСat Starter

## Версии и конфигурация

Версия PHP - 7.4
Версия MySQL - 8

Расширения PHP и конфигурация в соответствии с [документацией](https://netcat.ru/developers/docs/install-and-settings/tech-requirements/).

## Файловая структура

- config/hosts - конфигурация Nginx хостов
- config/mysql.cnf - конфигурация MySql
- config/php.ini - конфигурация PHP
- data/logs - логи собираемые Nginx
- data/mysql - база данных
- www/public - папка для проекта по умолчанию

## Руководство по запуску

У вас уже должен быть установлен Docker версии 17.04.0 или выше.

Клонируем репозиторий
```bash
git clone https://github.com/newfox79/netcat_starter.git

cd netcat_starter

rm -rf .git
```

C [официального сайта netcat](https://netcat.ru/democentre/) скачиваем любую редакцию и распаковываем её в data/www/public

Запускаем платформу
```bash
docker-compose up -d
```

После запуска переходим на страницу localhost, нажимаем "приступить к проверке"

На этапе проверки БД вводим следующие данные:

| Поле          | Значение     |
|---------------|--------------|
| host          | mysql        |
| database name | test         |
| user          | admin        |
| password      | QLuVNs573e2U |

Доступы к БД и имя базы данных можно изменить в файле docker-compose.yaml в mysql > environment