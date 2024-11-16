# Site

## À propos

Ce a été créé en 2017 puis refais en 2020.

Celui-ci est un site vitrine qui permet aux administrateurs de serveur [FiveM](https://fivem.net/) de gérer les métiers de chaque joueurs.

Les joueurs ont la possibilité de postuler à un métier direcement depuis le site.

Ce processus facilite le recrutement pour les différents métiers sur un serveur RP.

Ce site utilise les api suivantes:

-[MySQL](https://github.com/indieteq/PHP-MySQL-PDO-Database-Class) By [Vivek Wicky Aswal](https://twitter.com/#!/VivekWickyAswal)

-[Quake 3 query class](https://github.com/ghermans/Fivereborn-Webmanager/blob/master/rcon/q3query.class.php) By [Manuel Kress](mailto:manuel.strider@web.de)

-[Steam](https://github.com/iignatov/LightOpenID) By [Mewp](mailto:mewp151@gmail.com)
  
## Table des matières

- [À propos](#à-propos)
- [Prérequis](#prérequis)
- [Installation](#installation)
- [Outils](#outils)
- [Auteurs](#auteurs)
- [Licence](#Licence)

### Prérequis

  -[MySQL](https://www.mysql.com/)
  
  -[PHP7](https://www.php.net/releases/index.php)
  
  -[Apache](https://httpd.apache.org/)

### Installation

-Installer et configurer votre serveur Apache ou faite votre propre installation MySQL/PHP.

-Configurer les fichiers en suivants:

[Steam](./api/steam/apikey.php)

[Login](./api/login.php) Line 5

[MySQL](./api/mysql/settings.ini.php)


## Outils

  *notepad++

## Auteurs
* **Samuel Boutin** _alias_ [@sami3737](https://github.com/sami3737)

## Licence

Ce projet est sous licence ``MIT License`` - voir le fichier [LICENSE](LICENCE.md) pour plus d'informations
