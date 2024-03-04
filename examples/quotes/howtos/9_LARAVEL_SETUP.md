# Laravel setup

## scaffolding quotes app

With developer user account:

```bash
cd /var/www/html/
composer create-project laravel/laravel quotes
cd quotes
composer require doctrine/dbal
chmod -R 777 bootstrap/cache
chmod -R 777 storage
```

## update setting files default-ssl.conf and 000-default.conf

```bash
sudo nano /etc/apache2/sites-available/default-ssl.conf
```

```text
<IfModule mod_ssl.c>
        <VirtualHost _default_:443>
                ServerAdmin webmaster@localhost
                ServerName quotes.local
                ServerAlias www.quotes.local
                DocumentRoot /var/www/html/quotes/public

                <Directory /var/www/html/quotes/public>
                    Options Indexes FollowSymLinks MultiViews
                    AllowOverride All
                    Require all granted
                    #Order allow,deny
                    #allow from all
                </Directory>

                LogLevel info ssl:warn

                ErrorLog ${APACHE_LOG_DIR}/quotes_error.log
                CustomLog ${APACHE_LOG_DIR}/quotes_access.log combined

                SSLEngine on

                SSLCertificateFile /etc/ssl/self_signed_certs/quotes.pem
                SSLCertificateKeyFile /etc/ssl/self_signed_certs/quotes.key

                <FilesMatch "\.(cgi|shtml|phtml|php)$">
                    SSLOptions +StdEnvVars
                </FilesMatch>

                <Directory /usr/lib/cgi-bin>
                    SSLOptions +StdEnvVars
                </Directory>
        </VirtualHost>
</IfModule>
```

```bash
sudo nano /etc/apache2/sites-available/000-default.conf
```

```text
<VirtualHost *:80>
        ServerAdmin webmaster@localhost
        ServerName quotes.local
        ServerAlias www.quotes.local
        DocumentRoot /var/www/html/quotes/public
        Redirect "/" "https://192.168.1.XXX/"

        <Directory /var/www/html/quotes/public>
            Options Indexes FollowSymLinks MultiViews
            AllowOverride All
            Require all granted
            #Order allow,deny
            #allow from all
        </Directory>

        LogLevel info ssl:warn

        ErrorLog ${APACHE_LOG_DIR}/quotes_error.log
        CustomLog ${APACHE_LOG_DIR}/quotes_access.log combined
</VirtualHost>
```

Finally:

```bash
apache2ctl configtest
sudo systemctl restart apache2
sudo systemctl status apache2 --no-pager
sudo systemctl status php-fpm --no-pager
```

### monitoring Apache web server through continuous reading of quotes_error.log

```bash
tail -f /var/log/apache2/quotes_error.log
```

## configure environment

The application will have access to data recorded in two databases, `laravel_db` for the proper functioning of the framework and `quotes_db` which will receive the application data.

```bash
nano .env
```

```text
...
APP_NAME=quotes
...
APP_ENV=local
APP_URL=https://192.168.1.XXX/

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=developer_username
DB_PASSWORD=some_passwd

QUOTES_DB=quotes_db
...
```

## databases setup

```bash
nano config/database.php
```

```php
...
        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'quotes' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('QUOTES_DB', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],
...
```

## Jetstream setup

```bash
composer require laravel/jetstream
php artisan jetstream:install livewire --teams --dark
npm install
npm run build
```

## token-based APIs

Open and edit `config/jetstream.php`

```bash
nano config/jetstream.php
```

```text
...
'features' => [
        // Features::termsAndPrivacyPolicy(),
        // Features::profilePhotos(),
        Features::api(),
        Features::teams(['invitations' => true]),
        Features::accountDeletion(),
    ],
...
```

## additional models

Now it's time to add the specific models of this application example:

```shell
php artisan make:model --help
php artisan make:model --migration Author
php artisan make:model --migration Article
php artisan make:model --pivot --migration Contributor
php artisan make:controller AuthorController --model=Author
php artisan make:controller ArticleController --model=Article
chown --recursive --verbose developer_username:www-data .
php artisan route:list
```

If, after having appropriately edited all files Blade and file `routes/web.php`, the routes defined there do not appear or an error indicating an undefined route is returned, the following commands may be useful:

```bash
php artisan route:clear
php artisan route:cache
php artisan route:list
```

## models

### extract of the class `quotes/app/Models/Author`

```php
class Author extends Model
{
    use HasFactory;
    protected $connection = 'quotes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'surname', 'nickname', 'email', 'suspended',
    ];

    /**
     * contributions
     *
     * @return BelongsToMany
     */
    public function contributions(): BelongsToMany {
        return $this->belongsToMany(Contributor::class)->withTimestamps();
    }
}
```

### extract of the class `quotes/app/Models/Article`

```php
class Article extends Model
{
    use HasFactory;
    protected $connection = 'quotes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title', 'subject', 'summary', 'content', 'deprecated',
    ];

    /**
     * contributors
     *
     * @return BelongsToMany
     */
    public function contributors(): BelongsToMany {
        return $this->belongsToMany(Contributor::class)->withTimestamps();
    }
}
```

### extract of the class `quotes/app/Models/Contributor`

At a certain point in development I preferred a new name for a field in table `contributor`:

```sql
ALTER TABLE `quotes_db`.`contributor` CHANGE COLUMN `is_interesting` `is_main_author` TINYINT(1) AFTER `id`;
```

```php
class Contributor extends Pivot
{
    protected $connection = 'quotes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'is_main_author', 'article_id', 'author_id',
    ];

    /**
     * authors
     *
     * @return BelongsToMany
     */
    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class);
    }

    /**
     * articles
     *
     * @return BelongsToMany
     */
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class);
    }
}
```

## fields in the migration code

### extract of the anonymous class that references table `authors`

```php
    protected $connection = 'quotes';
```

```php
    public function up(): void
    {
        Schema::create('authors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->string('nickname')->nullable();
            $table->string('email')->unique();
            $table->boolean('suspended')->default(0);
            $table->timestamps();
        });
    }
```

### extract of the anonymous class that references table `articles`

```php
    protected $connection = 'quotes';
```

```php
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('subject');
            $table->text('summary')->nullable();
            $table->text('content');
            $table->boolean('deprecated')->default(0);
            $table->timestamps();
        });
    }
```

### extract of the anonymous class that references table `contributors`

```php
    protected $connection = 'quotes';
```

```php
    public function up(): void
    {
        Schema::create('contributors', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_main_author')->nullable();
            $table->unsignedBigInteger('article_id');
            $table->unsignedBigInteger('author_id');
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
            $table->foreign('author_id')->references('id')->on('authors')->onDelete('cascade');
            $table->timestamps();
        });
    }
```

And, after modifying the classes involved in the migration, I issued the following shell commands:

```bash
php artisan migrate --pretend
php artisan migrate
```

## inspect models

Here's how to inspect models and their relationships:

```bash
php artisan model:show Author
php artisan model:show Article
php artisan model:show Contributor
```

## inspect tables

```bash
php artisan db:table --database=quotes authors
php artisan db:table --database=quotes articles
```

## make controllers

```bash
php artisan make:controller AuthorController --model=Author
php artisan make:controller ArticleController --model=Article
```
