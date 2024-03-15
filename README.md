Project based on [dunglas/symfony-docker](https://github.com/dunglas/symfony-docker)

# Info
#### Application to send notifications using different broadcast channels through different providers<br>
PHP 8.2<br>
Symfony 5.4<br>
Postgres 16

# Starter (this one can take some time...)
```bash
composer install
docker compose build --no-cache
docker compose up -d
docker compose exec php bin/console make:migration
docker compose exec php bin/console doctrine:migrations:migrate
```

Flow is simple:
1. create notification with its data and channels info
```bash
curl -k --location 'http://localhost/notifications/create' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--data-raw '{
    "user_id": 1,
    "title": "title",
    "body": "body",
    "emails": ["test@email.com"],
    "sms": ["phone-number"],
    "pushes": ["device_token"]
}'
```
2. queue created notification to be sent (todo config crontab to run this every 5 min or so)
```bash
docker compose exec php bin/console notifications:queue -vvv
```
3. since messenger is set to work in sync mode, previous command will actually "sent" messages to the users
