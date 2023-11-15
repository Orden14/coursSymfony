# Projet symfony

## Auteur
Thomas lesrel

## Classe
B3 développement web & applications

## Lancer le projet
Pour faciliter l'éxecution du projet sur toutes les machines, il est préférable de posséder docker ainsi que yarn. <br>
Pour lancer le projet, se placer dans la root directory du projet puis :
- docker-compose up (dockerise une base de données pour le projet)
- yarn run dependencies (ou : composer install && yarn install && yarn build)
- yarn run truncate-database
- yarn run server-start
</br>
Le projet sera accessible sur localhost:8001
Phpmyadmin sera accessible sur localhost:8080

## Utilisateurs
Des utilisateurs de test par défaut sont disponibles grâce aux fixtures : 
- Admin : (username : admin / password : admin)
- User classique : (username : technicien / password : technicien)
