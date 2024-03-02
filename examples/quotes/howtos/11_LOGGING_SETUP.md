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
