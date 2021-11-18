# Vehicle

## Installation

### Pre-requisites

- `PHP >=7.4`
- `Composer`
- `PostgreSQL`

### Step 1: Install packages and build

- Install `composer` packages
    ```shell
    composer install
    ```

### Step 2: Setup PostgreSQL configuration

- Copy `.env` file to `.env.local`
    ```shell
    cp .env .env.local
    ```
- Change `db_user`, `db_password` and `db_name` in `.env.local` file

### Step 3: Execute database migrations

- Create database
    ```shell
    php bin/console doctrine:database:create
    ```
- Create tables
    ```shell
    php bin/console doctrine:migrations:migrate
    ```

### Step 4: Insert systems and locations data
- Insert
    ```shell
    php bin/console doctrine:fixtures:load 
    ```
###  Run application

- 
    ```shell
    php bin/console task:create
    ```

