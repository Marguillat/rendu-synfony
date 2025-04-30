# Rendu symfony : Wordpraisse CMS

Ce projet est basé sur le sujet du mini cms avec sa gestion d'articles.
- [Rendu symfony : Wordpraisse CMS](#rendu-symfony--wordpraisse-cms)
  - [Equipe](#equipe)
  - [Documentation](#documentation)
    - [Pré requis](#pré-requis)
    - [Environnement](#environnement)
    - [Lancer le projet](#lancer-le-projet)
  - [MPD](#mpd)
  - [Références](#références)

## Equipe

- [Louka Lemonier](https://github.com/loukalost) - Je tiens à préciser que mon fichier reponses.md est sur la branche louka
- [Erwan DUCHÊNE](https://github.com/Marguillat)

## Documentation

### Pré requis

- `composer` d'installé
- `php` Sur windows :
- `libpq` > version 13

Si besoin :

- `Docker`
- `mailPit`

---
### Environnement
Ce projet peut être lancé avec ou sans l'utilisation d'une base de donnée distante ou une bdd dockerisée.

Vous pouvez décider de l'emplacement de votre bdd dans le fichier ``.env``.

Pour une bdd distante cloud :
~~~~
DATABASE_URL="postgresql://neondb_owner:npg_N9hP2DfMLWVQ@ep-ancient-wind-a28evwjk.eu-central-1.aws.neon.tech/neondb?sslmode=require"
~~~~

Pour une bdd dockerisée :
~~~~
DATABASE_URL="postgresql://app:!ChangeMe!@127.0.0.1:55555/app?serverVersion=16&charset=utf8"
~~~~

Pour mailPit :

~~~~
###> symfony/mailer ###
#### Port sur lequel votre mailpit tourne (port docker ou port réel)
MAILER_DSN=smtp://localhost:1025
###< symfony/mailer ###
~~~~

### Lancer le projet

~~~~
composer install
php bin/console doctrine:migrations:migrate
~~~~
---

Avec docker :

```
docker compose up -d
```

Sans docker :

```
mailpit
```

---

lancement du serveur

```
symfony server:start -d
```

## MPD

Ce cms très simple fonctionne dans la relation décrite sur ce shéma MPD
![alt text](<public/images/mpd rendu -symfony.drawio.png>)

## Références

Références des différents outils/documentations utilisées afin de réaliser ce
projet

- symfony/twig documentation
  - [forms](https://symfony.com/doc/current/forms.html)
  - [format date](https://twig.symfony.com/doc/3.x/filters/date.html)

  - [user et entity](https://symfony.com/doc/current/security.html#the-user)

- [LeChat - Mistral AI](https://chat.mistral.ai/chat)
- [ReadMe](https://readme.so)
