# Réponses au sujet

## Pattern MVC
![alt text](public/images/pattern-mvc.svg)
- Le **Controlleur** dépend du **Modèle**  et de la **Vue**
- La Vue n'est pas nécessairement dépendante du Modèle
- Le Modèle est indépendant du **Controlleur** et de la **Vue**

## Qu'est ce qu'une session dans le cadre d'une application web ?
Dans le cadre d'une application web, une session est un objet représentant une interraction entre un utilisateur (souvent authentifié) et le serveur.
Cette session est stockée sur le serveur et possède une date de fin de validité. Cette session rend notre application stateFUL, à l'inverse d'une application REST qui elle est normalement stateLESS. Elle permet la plupart du temps de collecter des informations ainsi que de maintenir une connexion authentifiée entre l'utilisateur et le service proposé par le serveur.

## Question 3 : session hijacking et session fixation
### Sessions Hijacking
![alt text](public/images/session-hijacking.svg)
Le session hijacking consiste en l'usurpation des cookies d'authentification d'un utilisateur, après que celui-ci ce soit authentifié sur un serveur.
Le pirate peut récupérer ces informations de connexions en se plaçant entre l'utilisateur et le serveur, ou bien en récupérant le cookie après qu'il soit arrivé sur la machine utilisateur.

#### Pour s'en prémunir
- Implémenter le protocol HTTPS afin de chiffrer les données transitant entre les différentes machines.
- Utiliser les attributs *HTTP-only* afin d'empécher la lecture et l'utilisation de ces cookies par des scripts.
- utilisation de jeton CSRF 

### Sessions Fixation

Le session fixation consiste à forcer un utilisateur à utiliser un identifiant de session connu de l'attaquant. Une fois l'utilisateur authentifié avec cet identifiant, l'attaquant peut utiliser la session pour accéder aux données sensibles.

#### Pour s'en prémunir
- Générer un nouvel identifiant de session après l'authentification de l'utilisateur.
- Invalider les sessions inactives après un certain temps.
- Utiliser des identifiants de session complexes et difficiles à deviner.
- Éviter d'accepter les identifiants de session provenant de sources non sécurisées (comme les paramètres d'URL).
