# Movie Project (Symfony 7 | React 18)

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

## If you don't have access to Symfony Command

Import ```movie-project_database_data.tar.zst``` in Docker with Extension **Volumes Backup & Share**

## Built With

* **Symfony 7**
* **React 18**
* **Axios**
* **Docker with PostgreSQL DB**

## Main dependencies

* **@symfony/webpack-encore** to add Webpack in a Symfony Project
* **easycorp/easyadmin-bundle** to create administration for the application
* **doctrine/orm** to manage data between Doctrine and the BDD
* **symfony/http-client** to request the Movie DB API

## Documentation

* https://react.dev/reference/react
* https://symfony.com/doc/current/index.html
* https://www.digitalocean.com/community/tutorials/react-axios-react
* https://www.docker.com/blog/how-to-use-the-postgres-docker-official-image/
* https://symfony.com/bundles/ux-react/current/index.html
* https://www.cloudways.com/blog/symfony-react-using-webpack-encore/
* https://www.dhiwise.com/post/how-to-fetch-and-display-data-from-api-in-react-js

## To be done
* **User authentification**
* **Administrator page**
* **Movie CRUD**