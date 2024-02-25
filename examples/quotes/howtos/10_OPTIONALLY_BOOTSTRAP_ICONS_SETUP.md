# Optionally Bootstrap icons setup

Optionally installation of the MIT licensed icons offered by Bootstrap.

## useful method to test the functioning of the icons before carrying out a new build

Just to give an example, in theory you could symbolically link the directory containing the icons.

```bash
npm i -D bootstrap-icons
ls -al /var/www/html/quotes/node_modules/bootstrap-icons
mkdir /var/www/html/quotes/public/icons
ln --symbolic --verbose /var/www/html/quotes/node_modules/bootstrap-icons /var/www/html/quotes/public/icons/bootstrap-icons
ls -al /var/www/html/quotes/public/icons/
```

Then add the referral link wherever it needs to be used:

```php
<link rel="stylesheet" href="https://192.168.1.XXX/icons/bootstrap-icons/font/bootstrap-icons.css">
```

Here is a list of the files to which to add the aforementioned tag:

* `resources/views/welcome.blade.php`
* `resources/views/layouts/app.blade.php`
* `resources/views/layouts/guest.blade.php`

To then be able to use the icons, for example, in the following way:

```php
<i class="bi bi-person-add icon-3"></i>
```

## two other methods that are more compliant with the documentation

```bash
npm i -D bootstrap-icons
```

In theory you could add this line of code to the first line of the `resources/css/app.css` file:

```text
@import '../../node_modules/bootstrap-icons/font/bootstrap-icons.css';
```

and then run the build:

```bash
npm run build
```

First of the last two methods that can be used. In the following files:

* `resources/views/welcome.blade.php`
* `resources/views/layouts/app.blade.php`
* `resources/views/layouts/guest.blade.php`

In theory, you should ensure that the following line of code is present:

```php
@vite(['resources/css/app.css', 'resources/js/app.js'])
```

so you can insert icons, for example, in the following way:

```php
<i class="bi bi-person-add icon-3"></i>
```

We now come to the second of the last two methods of which I found some hints. With the premise of wanting to use icons by recalling them as characters, it seems necessary to ensure that the woff and woff2 files are present in the `public/build/assets` directory. Then, it seems you need to add the following files to the `public/assets` directory:

* `bootstrap-icons-fonts.css`

Maybe it should look like the following:

```css
@font-face {
    font-family: "Bootstrap Icons";
    src: url("https://192.168.1.XXX/build/assets/bootstrap-icons-nnnnnnnn.woff") format("woff");
}

@font-face {
    font-family: "Bootstrap Icons";
    src: url("https://192.168.1.XXX/build/assets/bootstrap-icons-nnnnnnnn.woff2") format("woff2");
}
```

* `bootstrap-icons-style.css`

Probably with something like the following:

```css
.bootstrap-icon {
    font-family: "Bootstrap Icons";
    font-style: normal;
}

.icon-red-1 {
    font-size: 0.75rem;
    color: #b33;
    padding: 0.25rem;
    pointer-events: none;
}

.icon-fuchsia-1 {
    font-size: 0.75rem;
    color: #67f;
    padding: 0.25rem;
    pointer-events: none;
}

.icon-red-2 {
    font-size: 2rem;
    color: #b33;
    pointer-events: none;
}

.icon-fuchsia-2 {
    font-size: 2rem;
    color: #67f;
    pointer-events: none;
}

.icon-red-3 {
    font-size: 3rem;
    color: #6d2222;
    padding: 1rem;
    pointer-events: none;
}

.icon-fuchsia-3 {
    font-size: 3rem;
    color: #67f;
    padding: 1rem;
    pointer-events: none;
}

.icon-grey-4 {
    font-size: 1.5rem;
    color: #999;
    padding: 0.5rem;
    pointer-events: none;
}

.icon-fuchsia-4 {
    font-size: 1.5rem;
    color: #67f;
    padding: 0.5rem;
    pointer-events: none;
}

.icon-fuchsia-5 {
    font-size: 0.75rem;
    color: #67f;
    padding: 0.25rem;
    pointer-events: none;
}
```

At this point, in theory, the following lines should be added:

```php
    <link rel="stylesheet" href="https://192.168.1.XXX/assets/bootstrap-icons-fonts.css">
    <link rel="stylesheet" href="https://192.168.1.XXX/assets/bootstrap-icons-style.css">
```

to the files:

* `resources/views/welcome.blade.php`
* `resources/views/layouts/app.blade.php`
* `resources/views/layouts/guest.blade.php`

Finally, to be able to use icons, you could, perhaps, use the `i` tag in the following way:

```php
<i class="bootstrap-icon icon-red-3">&#xf89a;</i>
```

or, again in theory, if you prefer, you could use the `span` tag as follows:

```php
<span class="bootstrap-icon icon-red-3">&#xf89a;</span>
```
