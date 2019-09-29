# Gestion des contacts LBC

### Prérequis
* [Docker](https://www.docker.com/)

### Installation

cloner le dossier depuis github:
```
$ git clone https://github.com/dju45/testtech2019.git .
```

lancer docker et se connecter aux conteneurs:
```
 docker-compose up -d
```
```
 docker-compose exec php-fpm sh
```

installer les dépendances via composer:
```
$ composer install .
```

configuration de la base de données dans le fichier `.env` 
```
DATABASE_URL=mysql://username:password@mysql/crm
```

créer la base de données:
```
$ bin/console doctrine:database:create .
```

jouer les migrations:
```
$ bin/console doctrine:migrations:migrate .
```

jouer les tests unitaires:
```
$ ./bin/phpunit .
```

pour accéder à localhost:
- [http://localhost:1025](http://localhost:1025)

pour accéder à adminer:
- [http://localhost:8080](http://localhost:8080)
