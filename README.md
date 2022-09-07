# PHP Intern – Lê Văn Định – 9/6/2022 – Lampart Answer Sheet

DE 1 - Category

## Requirement

-   PHP 8.1

## Step 1 - Copy file config.example.php to config.php

```bash
cp config.example.php config.php
```

After that, you can change the config in `config.php` file.

## Step 2 - Migrate database Or use the database in `database.sql` file

```bash
php migration.php
```

If you want to use the database in `database.sql` file, you can rescore the database with name `lampart`.

## Step 3 - Start app with built-in PHP server

```bash
php -S localhost:8000 public/index.php
```

Now you can access to `http://localhost:8000` to see the result.
