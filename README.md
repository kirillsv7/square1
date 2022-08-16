Install and launch:

```bash
$ docker run --rm \ 
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
$ cp .env.example .env
$ ./vendor/bin/sail up -d
$ ./vendor/bin/sail artisan key:generate
$ ./vendor/bin/sail artisan migrate:fresh --seed
$ ./vendor/bin/sail npm install
$ ./vendor/bin/sail npm run dev
$ ./vendow/bin sail artisan test
$ ./vendor/bin/sail down #stop project
```

Visit http://localhost or add square1.test to your hosts file and visit http://square1.test

Access data:
- admin@square1.io / password
- author@square1.io / password

Check database/seeders/DatabaseSeeder.php to find actual user data

Auto import posts using command:
```bash
$ ./vendor/bin/sail artisan import:posts
```