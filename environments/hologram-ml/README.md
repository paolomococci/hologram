# hologram-ml

Preparing a web application server that implements the LAMP stack thanks to Ubuntu server 24.04 LTS.
The system will be equipped with the latest stable versions of the PHP and Python programming languages.

## to get feedback on how the `LAMP` environment is working

Type the following commands:

```bash
cd /var/www/
sudo chown --recursive developer_username:www-data html/
cd html/
nano index.php
```

and then write the following code:

```php
<?php

phpinfo(INFO_ALL);
```

## a starting point

Once the steps listed here have been carried out, you will obtain a virtual machine ready to be cloned and adapted for the development of an `LAMP` style web application which can also use the technologies offered by `node.js` and `Python`.
