# Movie Project (Symfony|React)

Thie application uses Symfony to read data from The movie DB API and store it in local DB then react displayes this data.

## To start application

```
composer install
docker compose up -d
npm install --force

bin/console app:import-movies
bin/console app:import-movies week

npm run dev
```

## Main dependencies
