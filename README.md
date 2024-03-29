# The Todoer API

This API exposes endpoints for a Todo Task recorder application. The features of this application are as follows: `User Authentication`, `Tasks`, `Sub-Tasks`, `Projects`, `Invitation`.

-   [Dependencies](#dependencies)
-   [Initial Setup](#initial-setup)
-   [Running Locally](#running-locally)
-   [Running database migrations](#running-database-migrations)
-   [API Documentation](#api-documentation)
-   [Emails](#emails)

## Dependencies

Before you get started, you need to install

[Docker Desktop](https://www.docker.com/products/docker-desktop).

[Composer](https://getcomposer.org/download/).

## Initial Setup

Clone the project from github by running the following command

```
git clone https://github.com/gabbyTI/todoer-api.git
```

## Running Locally

From inside the `todoer-api` folder run the following command.

```
composer run project-setup-development
```

Now, to run the project in a docker environment, run the following command.

```
docker-compose up -d
```

The first time you run the above command it takes a few minutes, but subsequent runs are quick.

Once the application's Docker containers have been started, you can access the application in your web browser at: [http://localhost:5055](http://localhost:6066).

## Running database migrations

Before running the migrations, make sure you have started the docker container by running the command in the previous step.

To run the migrations, run the following command.

```
docker exec todoer-php php artisan migrate
```

## API Documentation

View the API documentation in [Postman API Doc](https://documenter.getpostman.com/view/9638778/Uz59NzKQ).

## Emails

View emails on mailhog here: [http://localhost:8025](http://localhost:8025).

## PhpMyAdmin

View the database with phpmyadmin dashboard: [http://localhost:8081](http://localhost:8081)
