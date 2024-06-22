# Composer setups

First I issued the following commands:

```bash
cd ~ && mkdir composer && cd composer
```

And after following the download instructions listed on the official Composer website I performed the actual global installation:

```bash
whereis php
sudo cp composer.phar /usr/local/bin/composer
composer list
```

## commands that may prove useful

To diagnose any problems:

```bash
composer --help diagnose
composer diagnose
```

## to update development tools:

If I find that I don't have an updated version of composer just issue the following commands:

```bash
composer -v
sudo composer self-update
```
