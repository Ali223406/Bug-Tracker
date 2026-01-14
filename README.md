Bug Tracker — Projet PHP


Un petit système de gestion de tickets développé en PHP / MySQL, permettant de créer, modifier, assigner et suivre des bugs.

- Fonctionnalités
Authentification (login / inscription)

Déconnexion

Création de tickets

Modification et suppression

Gestion des statuts (Open / In Progress / Closed)

Gestion des priorités

Assignation à un utilisateur

Vue “Tous les tickets”

Vue “Mes tickets”

Gestion des catégories

Dates de création et résolution





-Structure du projet

Bug-Tracker/
│
├── config/
│ └── config.php
│
├── public/
│ ├── login.php
│ ├── subscribe.php
│ ├── style.css
│ └── hashexample.php
│
├── private/
│ ├── dashboard.php
│ ├── ticket_form.php
│ ├── ticket_save.php
│ ├── ticket_delete.php
│ ├── ticket_update.php
│
├── Tests/
│ ├── tests.php
│ ├── tests_login.php
│ └── tests_subscribe.php
│
├── alicia_bugtracker.sql
└── README.md

- Prérequis
XAMPP, WAMP ou MAMP

PHP 8+

MySQL / MariaDB

Navigateur web

Installation
Cloner le projet ou le déposer dans :

C:/xampp/htdocs/Bug-Tracker
Démarrer Apache et MySQL via XAMPP.

Ouvrir phpMyAdmin → créer une base nommée :

bugtracker
Importer le fichier SQL fourni :

alicia_bugtracker.sql

Vérifier le fichier de configuration :

config/config.php

Lancer le projet
Accueil :

http://localhost/Bug-Tracker/

Page de Login :

http://localhost/Bug-Tracker/public/login.php

Dashboard (espace privé) :

http://localhost/Bug-Tracker/private/dashboard.php

- Identifiants par défaut


Admin

Email : admin@bugtracker.com

Mot de passe : 123456

- Auteur


Projet réalisé par Alicia Mazo.

 Notes supplémentaires
Le fichier .gitignore exclut les fichiers sensibles.

Le projet fonctionne 100% en local.


