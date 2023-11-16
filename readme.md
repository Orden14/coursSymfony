# Projet symfony

## Auteur
Thomas L.
B3 développement web & applications

## Lancer le projet
Pour faciliter l'éxecution du projet sur toutes les machines, il est préférable de posséder docker ainsi que yarn.  
Pour lancer le projet, se placer dans la root directory du projet puis :
- docker-compose up (dockerise une base de données pour le projet ainsi que maildev)
- yarn run dependencies
- yarn run truncate-database
- yarn run server-start  

Le projet sera accessible sur http://localhost:8001  
Maildev sera accessible sur http://localhost:1080/

## Maildev
Maildev est un outil permettant de recevoir les emails dans un environnement de développement afin de tester nos features  
Tant que le container est lancé, vous pouvez consulter tous les mails ayant transités sur l'application depuis http://localhost:1080/

## Utilisateurs
Des utilisateurs de test par défaut sont disponibles grâce aux fixtures : 
- Admin : (username : admin / password : admin)
- User classique : (username : technicien / password : technicien)
