# EcoRide - Projet Covoiturage

Bienvenue dans le projet **EcoRide**, une plateforme web de covoiturage écologique, développée dans le cadre d’une formation Développeur Web & Web Mobile.

## Version MVP (Minimum Viable Product)

Cette version MVP se concentre sur la **fonctionnalité principale** : permettre aux utilisateurs de rechercher des trajets.

## Fonctionnalités complémentaires implémentées

- Consultation du détail d'un trajet
- Inscription et connexion utilisateur

## Technologies utilisées

- **Frontend** : HTML5, CSS3, JavaScript (Vanilla)
- **Backend** : PHP (Vanilla)
- **Base de données** : MariaDB, MongoDB
- **Dépendances** : phpdotenv, mongodb/mongodb
- **Outils** : Docker, Composer
- **Conception** : Figma, Notion

## Lancer le projet en local

1. Cloner le projet où vous le souhaitez.
2. Copier le fichier `.env.example` en `.env`.
3. Lancer l'application avec Docker :

```sh
docker compose up --build
```

4. Installer les dépendances PHP avec Composer :

```sh
docker compose exec web composer install
```

5. Le site est alors accessible sur [http://localhost:8080](http://localhost:8080) et l'interface PhpMyAdmin sur [http://localhost:8081](http://localhost:8081).

## Auteur

Ce projet a été réalisé par Christophe dans le cadre d’un examen de formation DWWM chez Studi.
