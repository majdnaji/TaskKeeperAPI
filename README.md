
# TaskKeeperAPI

This repository contains a Laravel-based API for a task management system, allowing users to create, update, and delete tasks, as well as view task lists and mark tasks as complete. Built using best practices for RESTful APIs, this system is designed for easy integration with front-end applications or other systems.





## Run Locally

Clone the project

```bash
  git clone https://github.com/majdnaji/TaskKeeperAPI.git
```

Go to the project directory

```bash
  cd TaskKeeperAPI
```

Install dependencies

```bash
  composer install
```

Create a database and add it to .env
```
DB_DATABASE={DB_NAME}
DB_USERNAME={DB_USERNAME}
DB_PASSWORD={DB_PASSWORD}
```
Run migartions and seeders
```bash
php artisan migrate --seed
```

## Tech Stack

Laravel, JWT, Spatie Laravel Permissions.


## Authors

- [@majdnaji](https://www.github.com/majdnaji)
- [Portfolio](https://majdnaji.com)

## Documentation
[TaskKeeperAPI Documentation](https://elements.getpostman.com/redirect?entityId=8691292-44d9df32-d5f3-4dd3-934c-b097132e6b65&entityType=collection)
