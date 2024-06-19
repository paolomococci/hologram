# Composer setups

First I issued the following commands:

```bash
mkdir composer && cd composer
```

And after following the instructions listed on the official Composer website I performed the actual global installation:

```bash
whereis php
sudo cp composer.phar /usr/local/bin/composer
composer list
```

When there are updates, you can use the following program to update the dependency manager Composer:

```bash
sudo composer self-update
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
