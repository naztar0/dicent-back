# Speech to text

## Environment setup

```
cp .env.example .env
```

Write your database and AWS credentials into the .env file.

## Docker setup

```
docker-compose build
docker-compose up -d
```

**Next commands run under the docker**

## Project setup

```
docker-compose exec mysql /usr/local/bin/setup.sh
docker-compose exec app composer install
docker-compose exec app php artisan key:generate
docker-compose exec web chown www-data:www-data -R /var/www/html/
docker-compose exec app /usr/bin/supervisord -c /etc/supervisor/supervisord.conf
```

## Rolling migrations

```
docker-compose exec app php artisan migrate
```

_If an error occurs while connecting to the database, you can type_ `docker-compose ps`_, get the name of the database host and paste it into the_ `.env` _file to the_ `DB_HOST` _field._

## Email setup

Retrieve your SMTP credentials using this [instruction](https://support.google.com/mail/answer/7126229) and write them into .env file.

## Setup for debugging

To use https in AWS requests without any certificates, modify the Guzzle library.

```
sed -i "s/'verify' *=> *true,/'verify'=>false,/" vendor/guzzlehttp/guzzle/src/Client.php
```

**Do not use this in production.**

Configure swagger.

```
mkdir -p public/vendor/swagger && cp swagger.yaml "$_"
```

Access to the Laravel Telescope can be obtained from this link
[http://<your-hostname>/telescope](http://127.0.0.1/telescope)

Access to the Laravel Horizon can be obtained from this link
[http://<your-hostname>/horizon](http://127.0.0.1/horizon)

Access to the Swagger docs can be obtained from this link
[http://<your-hostname>/docs](http://127.0.0.1/docs)
