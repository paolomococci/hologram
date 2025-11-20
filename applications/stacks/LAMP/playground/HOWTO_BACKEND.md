# using the `php artisan` command, the `tinker` command, and vanilla SQL statements

## I create the models, migrations, factories and seeders for each entity

- **a `model` in Laravel is a class that represents a database table and provides the interface to read, create, update and delete records using Eloquent ORM**

- **a `migration` in Laravel is a PHP file that defines changes to the database structure (creation, modification or deletion of tables and columns) in a versioned and repeatable way**

- **a `factory` in Laravel is a class that defines how to create dummy (fake) instances of an Eloquent model for database testing and seeding purposes**

- **a `seeder` in Laravel is a class that populates the database with initial or dummy data**

## `php artisan` commands

After positioning myself in the root of the project I can issue the following commands:

```shell
php artisan make:model --help
php artisan make:model Category --migration --factory --seed
php artisan make:model Customer --migration --factory --seed
php artisan make:model Employee --migration --factory --seed
php artisan make:model Order --migration --factory --seed
php artisan make:model OrderDetail --migration --factory --seed
php artisan make:model Product --migration --factory --seed
php artisan make:model Shipper --migration --factory --seed
php artisan make:model Supplier --migration --factory --seed
```

### migration

```shell
php artisan migrate --pretend
php artisan migrate
```

### migration of a single table at a time

```shell
php artisan migrate:status
```

Migrating the `categories` table

```shell
php artisan migrate --pretend --path=./database/migrations/2025_11_18_203042_create_categories_table.php
php artisan migrate --path=./database/migrations/2025_11_18_203042_create_categories_table.php
php artisan db:seed --class=CategorySeeder
```

Migrating the `customers` table

```shell
php artisan migrate --pretend --path=./database/migrations/2025_11_18_203100_create_customers_table.php
php artisan migrate --path=./database/migrations/2025_11_18_203100_create_customers_table.php
php artisan db:seed --class=CustomerSeeder
```

Migrating the `employees` table

```shell
php artisan migrate --pretend --path=./database/migrations/2025_11_18_203127_create_employees_table.php
php artisan migrate --path=./database/migrations/2025_11_18_203127_create_employees_table.php
php artisan db:seed --class=EmployeeSeeder
```

Migrating the `shippers` table

```shell
php artisan migrate --pretend --path=./database/migrations/2025_11_18_203208_create_shippers_table.php
php artisan migrate --path=./database/migrations/2025_11_18_203208_create_shippers_table.php
php artisan db:seed --class=ShipperSeeder
```

Migrating the `suppliers` table

```shell
php artisan migrate --pretend --path=./database/migrations/2025_11_18_203222_create_suppliers_table.php
php artisan migrate --path=./database/migrations/2025_11_18_203222_create_suppliers_table.php
php artisan db:seed --class=SupplierSeeder
```

Migrating the `products` table

```shell
php artisan migrate --pretend --path=./database/migrations/2025_11_18_203159_create_products_table.php
php artisan migrate --path=./database/migrations/2025_11_18_203159_create_products_table.php
php artisan db:seed --class=ProductSeeder
```

Migrating the `orders` table

```shell
php artisan migrate --pretend --path=./database/migrations/2025_11_18_203138_create_orders_table.php
php artisan migrate --path=./database/migrations/2025_11_18_203138_create_orders_table.php
php artisan db:seed --class=OrderSeeder
```

Migrating the `order_details` table

```shell
php artisan migrate --pretend --path=./database/migrations/2025_11_18_203150_create_order_details_table.php
php artisan migrate --path=./database/migrations/2025_11_18_203150_create_order_details_table.php
php artisan db:seed --class=OrderDetailSeeder
```

### rollback the last database migration

```shell
php artisan migrate:rollback --pretend
php artisan migrate:rollback
```

### rollback all database migrations

```shell
php artisan migrate:reset --pretend
php artisan migrate:reset
```

### drop all tables and re-run all migrations

```shell
php artisan migrate:fresh --pretend
php artisan migrate:fresh
```

### seed the database with fake records

```shell
php artisan db:seed --help
php artisan db:seed --pretend
php artisan db:seed
```

### drop all tables, views, and types

```shell
php artisan db:wipe --help
```

### display information about the given database:

```shell
php artisan db:show --help
php artisan db:show --database=sqlite
php artisan db:show --database=mariadb
```

### display information about the given database table:

```shell
php artisan db:table --help
php artisan db:table categories --database=mariadb
php artisan db:table customers --database=mariadb
php artisan db:table employees --database=mariadb
php artisan db:table shippers --database=mariadb
php artisan db:table suppliers --database=mariadb
php artisan db:table products --database=mariadb
php artisan db:table orders --database=mariadb
php artisan db:table order_details --database=mariadb
```

---

## technical analysis from inside the container hosting the database

```shell
podman exec -it lamp-playground-db sh
mariadb -u root -p
```

Now from inside the SQL shell:

```sql
USE playground_db;
SHOW TABLES;
DESCRIBE categories;
DESCRIBE customers;
DESCRIBE employees;
DESCRIBE shippers;
DESCRIBE suppliers;
DESCRIBE products;
DESCRIBE orders;
DESCRIBE order_details;
```

Or, for a more in-depth analysis:

```sql
SELECT
    COLUMN_NAME,
    COLUMN_TYPE,
    IS_NULLABLE,
    COLUMN_DEFAULT,
    COLUMN_KEY, EXTRA,
    CHARACTER_SET_NAME,
    COLLATION_NAME
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'categories'
    ORDER BY ORDINAL_POSITION;
```

### Query examples

1. Orders with customer, employee, and shipping information

```sql
CREATE VIEW vw_order_full_details AS
SELECT
    o.OrderID,
    o.OrderDate,
    c.CustomerName,
    e.FirstName   AS EmployeeFirst,
    e.LastName    AS EmployeeLast,
    s.ShipperName
    FROM orders o
    INNER JOIN customers c ON o.CustomerID = c.CustomerID
    INNER JOIN employees  e ON o.EmployeeID = e.EmployeeID
    INNER JOIN shippers   s ON o.ShipperID = s.ShipperID
    ORDER BY o.OrderDate DESC;
```

The result will show the latest batch of orders, who created them and who shipped them:

```sql
SELECT * FROM vw_order_full_details LIMIT 50;
```

2. Complete details of an order (for example: `OrderID = 1234`)

```sql
CREATE VIEW vw_order_enriched AS
SELECT
    od.OrderDetailID,
    o.OrderID,
    o.OrderDate,
    p.ProductName,
    p.Price,
    od.Quantity,
    c.CategoryName,
    su.SupplierName
    FROM order_details od
    INNER JOIN orders   o ON od.OrderID = o.OrderID
    INNER JOIN products p ON od.ProductID = p.ProductID
    LEFT JOIN categories c ON p.CategoryID = c.CategoryID
    LEFT JOIN suppliers  su ON p.SupplierID = su.SupplierID;
```

Here `LEFT JOIN` will allow you to display products even if, for some reason, the category or supplier is missing, for example: `OrderID = 1234`:

```sql
SELECT * FROM vw_order_enriched WHERE OrderID = 1234;
```

3. Total sales per product

```sql
CREATE VIEW vw_product_total_sales AS
SELECT
    p.ProductID,
    p.ProductName,
    SUM(od.Quantity)            AS UnitsSold,
    SUM(od.Quantity * p.Price)  AS Revenue
    FROM order_details od
    INNER JOIN products p ON od.ProductID = p.ProductID
    GROUP BY p.ProductID, p.ProductName;
```

Excellent for understanding which products generate the most revenue. From an ABC analysis perspective:

```sql
SELECT * FROM vw_product_total_sales ORDER BY Revenue DESC;
```

4. Total sales by category

```sql
CREATE VIEW vw_sales_by_category AS
SELECT
    c.CategoryID,
    c.CategoryName,
    SUM(od.Quantity)            AS UnitsSold,
    SUM(od.Quantity * p.Price)  AS Revenue
    FROM order_details od
    INNER JOIN products p ON od.ProductID = p.ProductID
    INNER JOIN categories c ON p.CategoryID = c.CategoryID
    GROUP BY c.CategoryID, c.CategoryName;
```

:

```sql
SELECT * FROM vw_sales_by_category ORDER BY Revenue DESC;
```

5. Unsold

```sql
CREATE VIEW vw_unsold AS
SELECT
    p.ProductID,
    p.ProductName
    FROM products p
    LEFT JOIN order_details od ON p.ProductID = od.ProductID
    WHERE od.OrderDetailID IS NULL
    ORDER BY p.ProductName;
```

:

```sql
SELECT * FROM vw_unsold;
```

6. A customer's order history, `CustomerID = 5`, for example

```sql
CREATE VIEW vw_customer_order_history AS
SELECT
    o.OrderID,
    o.OrderDate,
    o.EmployeeID,
    s.ShipperName
    FROM orders o
    INNER JOIN customers c ON o.CustomerID = c.CustomerID
    LEFT JOIN shippers s ON o.ShipperID = s.ShipperID
    WHERE c.CustomerID = 5
    ORDER BY o.OrderDate DESC;
```

:

```sql
SELECT * FROM vw_customer_order_history;
```

---

## technical analysis from inside the container hosting the web app

```shell
podman exec -it --privileged lamp-playground-app bash
cd /var/www/html/playground/
php artisan tinker
```

Query on tables:

```shell
echo json_encode(array_map(fn($row)=>(array)$row, DB::connection('mariadb')->select('SHOW TABLES')), JSON_PRETTY_PRINT);
echo json_encode(array_map(fn($row)=>(array)$row, DB::connection('mariadb')->select('SELECT * FROM categories')), JSON_PRETTY_PRINT);
echo json_encode(array_map(fn($row)=>(array)$row, DB::connection('mariadb')->select('SELECT * FROM customers')), JSON_PRETTY_PRINT);
echo json_encode(array_map(fn($row)=>(array)$row, DB::connection('mariadb')->select('SELECT * FROM employees')), JSON_PRETTY_PRINT);
echo json_encode(array_map(fn($row)=>(array)$row, DB::connection('mariadb')->select('SELECT * FROM shippers')), JSON_PRETTY_PRINT);
echo json_encode(array_map(fn($row)=>(array)$row, DB::connection('mariadb')->select('SELECT * FROM suppliers')), JSON_PRETTY_PRINT);
echo json_encode(array_map(fn($row)=>(array)$row, DB::connection('mariadb')->select('SELECT * FROM products')), JSON_PRETTY_PRINT);
echo json_encode(array_map(fn($row)=>(array)$row, DB::connection('mariadb')->select('SELECT * FROM orders')), JSON_PRETTY_PRINT);
echo json_encode(array_map(fn($row)=>(array)$row, DB::connection('mariadb')->select('SELECT * FROM order_details')), JSON_PRETTY_PRINT);
```

Queries that return a JSON object:

```shell
# Orders with customer, employee, and shipping information
echo json_encode(array_map(fn($row)=>(array)$row, DB::connection('mariadb')->select('SELECT * FROM vw_order_full_details LIMIT 50')), JSON_PRETTY_PRINT);
# Complete details of an order (for example: `OrderID = 1234`)
echo json_encode(array_map(fn($row)=>(array)$row, DB::connection('mariadb')->select('SELECT * FROM vw_order_enriched WHERE OrderID = 1234')), JSON_PRETTY_PRINT);
# Total sales per product
echo json_encode(array_map(fn($row)=>(array)$row, DB::connection('mariadb')->select('SELECT * FROM vw_product_total_sales ORDER BY Revenue DESC')), JSON_PRETTY_PRINT);
# Total sales by category
echo json_encode(array_map(fn($row)=>(array)$row, DB::connection('mariadb')->select('SELECT * FROM vw_sales_by_category ORDER BY Revenue DESC')), JSON_PRETTY_PRINT);
# Unsold
echo json_encode(array_map(fn($row)=>(array)$row, DB::connection('mariadb')->select('SELECT * FROM vw_unsold')), JSON_PRETTY_PRINT);
# A customer's order history, `CustomerID = 5`, for example
echo json_encode(array_map(fn($row)=>(array)$row, DB::connection('mariadb')->select('SELECT * FROM vw_customer_order_history')), JSON_PRETTY_PRINT);
```
