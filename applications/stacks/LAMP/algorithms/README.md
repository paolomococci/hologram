# `algorithms` modularization of a blog installation

I start by positioning myself in the directory where I will collect the development environment:

```shell
ls -al ~/applications/stacks/LAMP/algorithms/
cd ~/applications/stacks/LAMP/algorithms/
```

I retrieve the images of interest so as not to have to download them every time:

```shell
podman pull mariadb:11.8.3-ubi9
podman pull wordpress:beta-php8.4-fpm-alpine
```

Possible cleaning of directories to be shared with containers:

If directories `data`, `html` and `conf` already exist I prefer to remove them:

```shell
podman pod rm dsa-data-pod
sudo rm -Rf data/ html/ conf/
```

## preparation of the development environment

I create directory for `data` volume:

```shell
mkdir --parents data/{mariadb,postgres} && chcon --recursive --type=container_file_t ./data/ && ls -ldZ ./data/
```

I create directory for `html` volume:

```shell
mkdir --parents html/{wordpress,nginx} && chcon --recursive --type=container_file_t ./html/ && ls -ldZ ./html/
```

I create directory for `conf` volume:

```shell
mkdir --parents conf/nginx-conf && chcon --recursive --type=container_file_t ./conf/ && ls -ldZ ./conf/
```

## I create pod `dsa-data-pod` with containers `wp-dsa-db`, `wp-dsa-app` and `wp-dsa-proxy`

I create the pod `dsa-data-pod` characterized with the shared network with ports 8080 and 3306 exposed:

```shell
podman pod create --name dsa-data-pod --publish 8080:80 --publish 3306:3306
```

I start the MariaDB database container:

```shell
podman run --detach --pod dsa-data-pod --name wp-dsa-db --user root --volume $(pwd)/data/mariadb:/var/lib/mysql:Z --env MYSQL_ROOT_PASSWORD=qwerty123 --env MYSQL_DATABASE=wordpress --env MYSQL_USER=wpuser --env MYSQL_PASSWORD=qwerty123 --env MYSQL_ALLOW_EMPTY_PASSWORD=no --restart=always --pull="never" mariadb:11.8.3-ubi9 --default-authentication-plugin=mysql_native_password --character-set-server=utf8mb4 --collation-server=utf8mb4_unicode_ci
```

I create the WordPress container:

```bash
podman run --detach --pod dsa-data-pod --name wp-dsa-app --volume $(pwd)/html/wordpress:/var/www/html:Z --env WORDPRESS_DB_HOST=wp-dsa-db --env WORDPRESS_DB_USER=wpuser --env WORDPRESS_DB_PASSWORD=qwerty123 --env WORDPRESS_DB_NAME=wordpress --env WORDPRESS_TABLE_PREFIX=wp_ --env WORDPRESS_DEBUG=1 --pull="never" wordpress:beta-php8.4-fpm-alpine
```

I create the container for the proxy server that accesses the same html volume as wordpress:

```bash
podman run --detach --pod dsa-data-pod --name wp-dsa-proxy --volume $(pwd)/html/wordpress:/var/www/html:Z --volume $(pwd)/conf/nginx-conf/default.conf:/etc/nginx/conf.d/default.conf:Z --pull="never" nginx:1.29.2-alpine3.22-perl
```

Now just point the browser to the HTTP link assigned to the service, I don't know, like: <http://192.168.XXX.XXX:8080/wp-login.php> to carry out the usual installation and management activities, remembering to replace the placeholder `192.168.XXX.XXX` with your IP address.

### inspect the logs:

```shell
podman logs wp-dsa-db
podman logs wp-dsa-app
podman logs wp-dsa-proxy
```

### ports check

```shell
podman ps --format "{{.Names}} {{.Ports}}"
```

### example of technical intervention from the perspective of the `nginx` container 

Without the need to enter the container:

```shell
podman exec -it wp-dsa-proxy ls -la /var/www/html
podman exec -it wp-dsa-proxy curl -I http://localhost/
podman exec -it wp-dsa-proxy curl -I http://localhost/wp-login.php
```

### example of technical intervention from the perspective of the `mariadb` container 

```shell
podman exec -it wp-dsa-db sh
mariadb -u root -p
```

To check the permissions granted to user `wpuser`:

```sql
SELECT User, Host FROM mysql.user WHERE User='wpuser';
SHOW GRANTS FOR 'wpuser'@'%';
USE wordpress;
```

### example of technical intervention from the perspective of the `wordpress` container 

By issuing commands from inside the container.

```shell
podman exec -it wp-dsa-app bash
```

Once inside the container:

```shell
ping -c 3 wp-dsa-db
```

If desired you can install the client for MariaDB:

```shell
apk add mysql-client
mariadb -h wp-dsa-db -u wpuser -p --database=wordpress
```

then from the sql shell:

```sql
SHOW DATABASES;
SHOW GRANTS FOR 'wpuser'@'%';
SHOW TABLES;
SELECT * FROM wp_users;
```

Some useful queries follow.

Amount of posts for each state:

```sql
SELECT post_status, post_type, COUNT(*) AS quantity
    FROM wp_posts
    GROUP BY post_status, post_type;
```

Quantity of users for each role:

```sql
SELECT meta.meta_value AS role, COUNT(*) AS quantity
    FROM wp_users u
    JOIN wp_usermeta meta ON meta.user_id = u.ID AND meta.meta_key = CONCAT('wp_', 'capabilities')
    GROUP BY meta.meta_value;
```

The top ten posts with the most comments:

```sql
SELECT p.ID, p.post_title, p.post_date, COUNT(c.comment_ID) AS comments
    FROM wp_posts p
    LEFT JOIN wp_comments c ON c.comment_post_ID = p.ID AND c.comment_approved = '1'
    WHERE p.post_type = 'post' AND p.post_status = 'publish'
    GROUP BY p.ID
    ORDER BY comments DESC
    LIMIT 10;
```

The top ten posts with comments in the last week:

```sql
SELECT p.ID, p.post_title, MAX(c.comment_date) AS last_comment
    FROM wp_posts p
    JOIN wp_comments c ON c.comment_post_ID = p.ID AND c.comment_approved = '1'
    WHERE c.comment_date >= NOW() - INTERVAL 7 DAY
    GROUP BY p.ID
    ORDER BY last_comment DESC
    LIMIT 10;
```

The top ten articles or posts listed by size:

```sql
SELECT ID, post_title, ROUND(CHAR_LENGTH(post_content)/1024,2) AS kb
    FROM wp_posts
    ORDER BY kb DESC
    LIMIT 10;
```

---

## stop/start the pod:

```bash
podman pod stop dsa-data-pod
podman pod start dsa-data-pod
```

## remove everything:

```bash
podman pod stop dsa-data-pod
podman pod rm dsa-data-pod
sudo rm -Rf data/
sudo rm -Rf html/
```