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

## commands that may prove useful

To diagnose any problems:

```bash
composer --help diagnose
composer diagnose
```

## to update development tools:

If I find that I don't have an updated version of composer, npm and node, just issue the following commands:

```bash
composer -v
sudo composer self-update
npm -v
node -v
sudo npm cache clean -f
sudo npm install -g n
sudo n stable
sudo npm install -g npm@latest
```
