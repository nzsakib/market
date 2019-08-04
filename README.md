
# Setup testing environment 

- Create a testing database in mysql
- save these information in `.env`
```
DB_TEST_CONNECTION=mysql
DB_TEST_HOST=127.0.0.1
DB_TEST_PORT=3306
DB_TEST_DATABASE=
DB_TEST_USERNAME=
DB_TEST_PASSWORD=
```

- run `php artisan migrate --database testing`
- `./vendor/bin/phpunit`



