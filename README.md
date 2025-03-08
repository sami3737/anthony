# Site

## À propos

Ce site a été créé en 2017 puis refait en 2020.

Ce site vitrine permet aux administrateurs de serveurs [FiveM](https://fivem.net/) de gérer les métiers de chaque joueur.

Les joueurs peuvent postuler à un métier directement depuis le site, facilitant ainsi le recrutement pour les différents métiers sur un serveur RP.

Ce site utilise les API suivantes :

- [MySQL](https://github.com/indieteq/PHP-MySQL-PDO-Database-Class) par [Vivek Wicky Aswal](https://twitter.com/#!/VivekWickyAswal)
- [Quake 3 query class](https://github.com/ghermans/Fivereborn-Webmanager/blob/master/rcon/q3query.class.php) par [Manuel Kress](mailto:manuel.strider@web.de)
- [Steam](https://github.com/iignatov/LightOpenID) par [Mewp](mailto:mewp151@gmail.com)

## Table des matières

- [À propos](#à-propos)
- [Prérequis](#prérequis)
- [Installation](#installation)
- [Fonctionnalités](#fonctionnalites)
- [Outils](#outils)
- [Auteurs](#auteurs)
- [Licence](#licence)

## Prérequis

Avant d’installer le site, assurez-vous d’avoir :

- [MySQL](https://www.mysql.com/)
- [PHP 7](https://www.php.net/releases/index.php)
- [Apache](https://httpd.apache.org/)

## Installation

1. Installer et configurer votre serveur Apache ou réaliser votre propre installation MySQL/PHP.
2. Configurer les fichiers suivants :
   - [Steam](./api/steam/apikey.php)
   - [Login](./api/login.php) (ligne 5)
   - [MySQL](./api/mysql/settings.ini.php)

## Fonctionnalités

- Gestion des métiers des joueurs sur un serveur FiveM.
- Système de candidature en ligne pour les joueurs.
- Interface administrateur pour gérer les recrutements.

## Outils

- [Notepad++](https://notepad-plus-plus.org/)
- Un éditeur de texte au choix (VS Code, Sublime Text, etc.)

## Auteurs

- **Samuel Boutin** _alias_ [@sami3737](https://github.com/sami3737)

## Licence

Ce projet est sous licence **MIT License** - voir le fichier [LICENSE](LICENSE.md) pour plus d'informations.
