# Composer setup with PHP 8.0.30

I issued the following commands:

```bash
mkdir composer && cd composer
```

And after following the instructions listed on the official Composer website I performed the actual global installation:

```bash
whereis php
sudo cp composer.phar /usr/bin/composer
composer list
```

## commands that may prove useful

To diagnose any problems:

```bash
composer --help diagnose
composer diagnose
```

To update `composer`:

```bash
sudo composer self-update
```
