## About application

This application is a proof of concept for a web service used to manage employees of a company.

## Tech stack

- **[PHP 8](https://php.com/)**
- **[Laravel 8](https://www.laravel.com/)**
- **[MySQL 8](https://dev.mysql.com/)**
- **[Docker](https://www.docker.com/)**

## Installation

This application uses Laravel Sail command-line interface, so the installation process is fairly simple. The prerequisite to be able to use Laravel Sail is to have a docker installed.

1. After you clone the project, open your favorite terminal, go to the root of the project and run:
    ```
    composer install
    ```
    ```
    ./vendor/bin/sail up -d
    ```
   That's it. Your project is now up on local docker environment. In order to use sail command instead of ./vendor/bin/sail, you can add alias in bash script:
    ```
    alias sail='bash vendor/bin/sail'
    ```
   Now, you can use sail command:
   ```
   sail up -d
   ```

2. Copy .env.example to .env.

3. Run DB migrations:
    ```
    sail artisan migrate
    ```

## Usage

API documentation is coming soon...
