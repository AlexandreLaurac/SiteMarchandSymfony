# Site marchand Symfony

Application web proposant un site marchand réalisée avec le framework Symfony de décembre 2022 à février 2023 dans le cadre du module "Framework de développement rapide en PHP" de la licence professionnelle.

Le site cible était consultable et devait être atteint au cours des TP du module se focalisant sur différents aspects du framework. Les TP mettaient en oeuvre les points suivants :
- TP1 : installations nécessaires à l'utilisation de Symfony, création et configuration pour le projet de la base de données à venir du site
- TP2 : ossature du site
  * écriture d'une base de template Twig, puis de l'ensemble des templates Twig dérivant de cette base et décrivant les pages du site, à partir du code source HTML des pages du site cible
  * définition des routes et écriture des contrôleurs correspondants pour naviguer sur le site
  * utilisation d'un service BoutiqueService fourni, codant dans un premier temps en dur les données du site (catégories de produits et produits)
- TP3 : mise en place d'un service de "traduction" pour deux "locales" (français et anglais). Le choix d'une langue peut se faire soit directement dans l'url (.../fr/... ou .../en/...) soit par choix d'une icône drapeau à droite de la barre de navigation. Les pages réalisées à la suite de ce TP ne seront plus "traduites".
- TP4 : élaboration d'un service réalisant un panier
  * écriture du service à partir d'une spécification avec opérations de base (ajout ou suppression d'un article, consultation ou calcul du montant du contenu, etc.) et stockage des articles choisis en session
  * définition des routes et écriture des contrôleurs et des templates pour les pages supplémentaires associées au panier
- TP5 : début de la persistance
  * création de deux entités Categorie et Produit et de leurs "repositories" associés
  * remplacement, dans tout le code du site, du service BoutiqueService précédemment fourni par les repositories des deux entités créées
- TP6 : compléments à la structure de données et suite de la persistance à partir d'un schéma relationnel fourni
  * création d'une entité Usager utilisée pour l'authentification sur le site et formulaire associé
  * création d'entités Commande et LigneCommande pour qu'un utilisateur puisse effectuer des commandes (les lignes de commandes constituant les détails d'une commande article par article)
  * transformation d'un panier en commande et lignes de commande (écriture de la méthode du service panier puis route, contrôleur et template associé au résultat de la commande)
- TP7 : mise en place de la sécurité du site
  * configuration du fichier security.yaml
  * adaptation du site à l'usager authentifié
- TP8 : formulaire d'inscription d'un usager basé sur le "form builder" de Symfony
- TP9, parmi les compléments proposés (top ventes, gestion des devises, envoi de mails, captcha) :
  * écriture d'une side bar donnant les meilleurs ventes

### Consultation du site

Pour pouvoir consulter le site sans avoir à cloner le code ni réaliser d'installation, l'application a été déployée sur la plateforme Always Data. Le site est disponible à l'adresse : [https://alexandrelaurac.alwaysdata.net](https://alexandrelaurac.alwaysdata.net). Un usager "test", d'email "test@test.com" et de mot de passe "test" peut être utilisé, mais on peut également créer un nouvel usager (et passer des commandes).

Si l'on veut tout de même consulter le site en local à partir du code disponible sur ce dépôt, il faut réaliser plusieurs installations (PHP, Symfony, Composer, un SGBDR), cloner le code, lancer la commande `composer install`, créer une base de données de nom "mi5" (code du module) destinée à recevoir les tables, configurer le fichier .env pour cette base (voir la ligne commençant par "DATABASE_URL") et enfin exécuter le fichier bdd.sql par la commande `psql --file bdd.sql -U mi5`. Le site se lance alors par la commande `symfony server:start --no-tls` et est disponible à l'adresse http://localhost:8000