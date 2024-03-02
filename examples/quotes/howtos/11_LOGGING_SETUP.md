# logging setup

## edit config/logging.php

I needed to add one or more channels for recording logs, to achieve this I had to type a code similar to the following in the `channels` array in the `config/logging.php` file.

```php
        'articles' => [
            'driver' => 'single',
            'path' => storage_path('logs/article.log'),
            'level' => 'info',
        ],

        'authors' => [
            'driver' => 'single',
            'path' => storage_path('logs/author.log'),
            'level' => 'info',
        ],
```

In this case I preferred to use more granular logging by setting it in the methods of the classes where I think it could be more useful.
By writing code, for example, similar to the following:

```php
Log::build([
    'driver' => 'single',
    'path' => storage_path('logs/article_error.log'),
])->error(json_encode($json));
```
