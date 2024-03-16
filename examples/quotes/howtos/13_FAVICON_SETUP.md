# favicon setup

Here is the list of files in which to insert the link to the favicon: 

* `resources/views/welcome.blade.php`
* `resources/views/layouts/app.blade.php`
* `resources/views/layouts/guest.blade.php`

I add this code:

```php
    <link rel="shortcut icon" href="https://192.168.1.XXX/favicon.ico" type="image/x-icon">
```

First, however, I created a 64x64 pixel icon using `GIMP`, saving it in png format, for example `hologram.png`.

Then I scaled it to the `ico` format using the tool `convert` to software suite `ImageMagick`:

```bash
convert hologram.png -define -icon:auto-resize=256,128,48,32,16 favicon.ico
```

In the end I copied it from my working directory, present on my machine from which I carry out the development, into the `public` directory present on the server where the web application runs:

```bash
scp favicon.ico developer_username@192.168.1.XXX:/var/www/html/v1/quotes/public
```

Or, if I wanted to reduce the memory footprint of the icon, I could use another open source tool, just as an example as follows:

```bash
pngnq -v hologram.png
```

And, after having appropriately renamed the image which has lightened its memory usage, again by way of example, I could copy it into directory `public` with the following commands:

```bash
scp hologram.png developer_username@192.168.1.XXX:/var/www/html/v1/quotes/public
```

By modifying the aforementioned link in the three files involved as follows:

```php
    <link rel="shortcut icon" href="https://192.168.1.XXX/hologram.png" type="image/png">
```
