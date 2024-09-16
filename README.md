# Movie Project (Symfony 7|React 18)

This application uses Symfony to retrieve data from The Movie DB API, store it in a local database, and then displays the data using React.

## To start application

```
composer install
docker compose up -d
npm install --force

bin/console app:import-movies
bin/console app:import-movies week

npm run dev
```

## Built With

1. [Symfony 7]
2. [React 18]
3. [Axios]
4. [Docker with PostgreSQL BDD]

## Main dependencies

* @symfony/webpack-encore to add Webpack in a Symfony Project
* easycorp/easyadmin-bundle to create administration for the application
* doctrine/orm to manage data between Doctrine and the BDD
* symfony/http-client to request the Movie DB API

## To be done
1. User authentification
2. Administrator page
3. Movie CRUD