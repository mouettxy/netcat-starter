# NetСat Starter

## Версии и конфигурация

Версия PHP - 7.4
Версия MySQL - 8

Расширения PHP и конфигурация в соответствии с [документацией](https://netcat.ru/developers/docs/install-and-settings/tech-requirements/).

## Файловая структура

- config/hosts - конфигурация Nginx хостов
- config/mysql.cnf - конфигурация MySql
- config/php.ini - конфигурация PHP
- config/ssl/open_ssl.conf - конфигурация SSL сертификата
- data/logs - логгирование
- data/mysql - база данных
- www/public - папка для проекта по умолчанию

## Руководство по запуску

У вас уже должен быть установлен Docker версии 17.04.0 или выше.

### Клонируем репозиторий
```bash
git clone https://github.com/newfox79/netcat_starter.git

cd netcat_starter

rm -rf .git
```

### Установка редакции

C [официального сайта netcat](https://netcat.ru/democentre/) скачиваем любую редакцию и распаковываем её в data/www/public

Запускаем платформу
```bash
docker-compose up -d
```

### SSL сертификат

В папке config/ssl уже находятся сгенерированные файлы localhost.crt и localhost.key, вы можете самостоятельно их подписать, или сгенерировать новые используя инструкцию ниже.

### Генерация собственного SSL сертификата

Вам может понадобится сгенерировать новый сертификат если вы хотите использовать домен отличный от домена по умолчанию - netcat-demo.dev.

У вас должен быть установлен openssl, обычно если при установке Git вы устанавливали Git Bash - то он у вас уже есть.

Заполняем config/ssl/open_ssl.conf по шаблону:
```
[req]
distinguished_name = req_distinguished_name
x509_extensions = v3_req
prompt = no
[req_distinguished_name]
C = <--COUNTRY CODE - 2 Characters-->
ST = <--PROVINCE/ STATE-->
L = <--CITY-->
O = <--ORGANISATION-->
OU = <--DEPARTMENT-->
CN = <--CERTIFICATE ISSUER NAME - Can be anything-->
[v3_req]
keyUsage = keyEncipherment, dataEncipherment
extendedKeyUsage = serverAuth
subjectAltName = @alt_names
[alt_names]
DNS.1 = <--DOMAIN NAME-->
DNS.2 = <--DOMAIN NAME 2-->
```

Генерируем сертификаты:
```bash
cd config/ssl

openssl req -x509 -nodes -days 1024 -newkey rsa:2048 -keyout CERT_NAME.key -out CERT_NAME.crt -config open_ssl.conf -extensions 'v3_req'
```

После этого в docker-compose.yaml -> services -> nginx -> volumes необходимо в двух последних пунктах скорректировать пути учитывая выбранное вами имя сертификата.

Так же в config/hosts/app.conf необходимо скорректировать домен и пути к сертификатам.

### Редактирование hosts файла

В файл C:\Windows\System32\drivers\etc\hosts необходимо внести строчку:
```
127.0.0.1 netcat-demo.dev
```

Если вы меняли домен, то замените netcat-demo.dev на свой домен.

### Установка редакции

Переходим на выбранный домен или домен по умолчанию https://netcat-demo.dev, нажимаем "приступить к проверке"

На этапе проверки БД вводим следующие данные:

| Поле          | Значение     |
|---------------|--------------|
| host          | mysql        |
| database name | test         |
| user          | admin        |
| password      | QLuVNs573e2U |

Доступы к БД и имя базы данных можно изменить в файле docker-compose.yaml в mysql > environment