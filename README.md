Garage Automobile - Application Web
Description
L'application "Garage Automobile" est un système complet de gestion de garage automobile, permettant de gérer les véhicules en vente, les services du garage (mécanique, entretien, carrosserie), ainsi que les utilisateurs du site (administrateurs, employés et clients). Ce projet est conçu avec Symfony, Docker, et utilise des bases de données PostgreSQL et Firebase pour un environnement de développement flexible. L'application est entièrement sécurisée et déployée avec Nginx pour le serveur HTTP.

Technologies Utilisées
Symfony : Framework PHP pour la gestion du backend et de la logique métier.
Docker : Conteneurisation de l'application, des services et de la base de données.
Nginx : Serveur HTTP pour gérer les requêtes web.
PostgreSQL : Base de données relationnelle pour stocker les données utilisateurs et annonces.
Firebase : Base de données NoSQL utilisée uniquement en développement pour stocker des données temporaires.
JWT (JSON Web Tokens) : Authentification et gestion des sessions utilisateurs via API sécurisées.
EasyAdmin : Interface d’administration pour la gestion des entités Symfony.
PHPUnit : Framework de tests unitaires pour garantir la stabilité du backend.
Postman : Outil utilisé pour tester les APIs HTTP de l'application.


Table des Matières
Prérequis
Installation et Déploiement
Architecture et Conteneurisation avec Docker
Configuration Nginx
Sécurisation de l'Application
Fonctionnalités de l'Application
Tests avec PHPUnit
Tests avec Postman
Conclusion


Prérequis Avant de commencer l'installation et la configuration, assurez-vous d'avoir les outils suivants installés sur votre machine :
Docker et Docker Compose : Pour la gestion des conteneurs.
PHP 8.1 ou supérieur : Nécessaire pour le développement avec Symfony.
Composer : Gestionnaire de dépendances pour PHP.
Git : Pour la gestion du code source.


Installation et Déploiement

1. Cloner le Répertoire du Projet
Clonez ce projet en local via Git :
git clone https://github.com/votre-utilisateur/garage-automobile.git
cd garage-automobile




2. Construire et Lancer les Conteneurs Docker
Utilisez Docker Compose pour démarrer les services définis dans le fichier docker-compose.yml (Nginx, PostgreSQL, Symfony).
docker-compose up --build
Cela construira l'image Docker pour l'application Symfony et démarrera les services nécessaires, y compris PostgreSQL et Nginx.




3. Accéder à l'Application
Une fois les conteneurs démarrés, l'application sera accessible à l'adresse suivante :
http://localhost




Architecture et Conteneurisation avec Docker

1. Structure du Projet Docker
   
Le projet utilise Docker pour exécuter les différents services dans des conteneurs isolés :
app : Conteneur pour l'application Symfony.
db : Conteneur pour PostgreSQL.
nginx : Conteneur pour le serveur web Nginx.
Dockerfile
Le Dockerfile configure l'environnement PHP avec toutes les extensions nécessaires, installe Composer pour la gestion des dépendances, et copie le code source de l'application dans le conteneur.

# Utilisation de l'image PHP avec FPM
FROM php:8.1-fpm

# Installation des dépendances
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libpq-dev \
    libzip-dev \
    git \
    unzip \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl pdo pdo_pgsql zip

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Répertoire de travail
WORKDIR /var/www

# Copie du code source
COPY . .

# Installation des dépendances Symfony
RUN composer install --no-dev --optimize-autoloader
docker-compose.yml


Le fichier docker-compose.yml configure les services nécessaires au bon fonctionnement de l'application :

yaml
Copier
Modifier
version: '3.8'

services:
  app:
    build:
      context: .
    container_name: garage_app
    working_dir: /var/www
    volumes:
      - .:/var/www
    networks:
      - garage_network
    depends_on:
      - db
    environment:
      - DATABASE_URL=pgsql://postgres:password@db:5432/garage_db

  db:
    image: postgres:13
    container_name: garage_db
    environment:
      POSTGRES_USER: postgres
      POSTGRES_PASSWORD: password
      POSTGRES_DB: garage_db
    volumes:
      - db_data:/var/lib/postgresql/data
    networks:
      - garage_network

  nginx:
    image: nginx:latest
    container_name: garage_nginx
    volumes:
      - ./docker/nginx.conf:/etc/nginx/nginx.conf
      - .:/var/www
    ports:
      - "80:80"
    networks:
      - garage_network

networks:
  garage_network:
    driver: bridge

volumes:
  db_data:
Configuration Nginx



Le serveur Nginx est utilisé pour servir les requêtes HTTP et rediriger celles-ci vers le backend Symfony en utilisant FastCGI. Voici la configuration de base pour Nginx (docker/nginx.conf):


server {
    listen 80;
    server_name localhost;

    root /var/www/public;
    index index.php;

    location / {
        try_files $uri /index.php$is_args$args;
    }

    location ~ \.php$ {
        fastcgi_pass app:9000;
        fastcgi_param SCRIPT_FILENAME /var/www$document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    error_log /var/log/nginx/error.log;
    access_log /var/log/nginx/access.log;
}



Configuration de la Base de Données PostgreSQL

Dans le fichier .env, configurez la connexion à la base de données PostgreSQL :
DATABASE_URL=pgsql://postgres:password@db:5432/garage_db

Les migrations de Doctrine sont exécutées via la commande suivante dans le conteneur app :
docker exec -it garage_app php bin/console doctrine:migrations:migrate
Sécurisation de l'Application
1. Sécurisation du Backend
Authentification avec JWT
L'application utilise JWT (JSON Web Tokens) pour sécuriser les APIs et gérer les sessions utilisateurs. Le bundle LexikJWTAuthenticationBundle est utilisé pour la gestion des tokens JWT.

Installation du bundle JWT :
composer require lexik/jwt-authentication-bundle

Configuration du Bundle :
Ajoutez la configuration dans config/packages/lexik_jwt_authentication.yaml :
lexik_jwt_authentication:
    secret_key: '%kernel.project_dir%/config/jwt/private.pem'
    public_key: '%kernel.project_dir%/config/jwt/public.pem'
    pass_phrase: '%env(JWT_PASSPHRASE)%'
    token_ttl: 3600


    
Sécurisation des Routes API
Le système d'authentification protège les routes via des tokens JWT. Par exemple, une route sécurisée pour accéder à la gestion des véhicules pourrait être configurée comme suit dans config/routes.yaml :
api_vehicles:
  path: /api/vehicles
  methods: [GET]
  controller: App\Controller\VehicleController::index
  requirements:
    _role: ROLE_ADMIN

    
Les contrôleurs qui nécessitent une authentification sont protégés par le middleware JWTAuthenticator de Symfony, qui valide les tokens dans l'entête Authorization des requêtes HTTP.

Gestion des Rôles et Permissions
L'application utilise Symfony Security pour gérer les rôles et permissions. Voici un extrait de la configuration de sécurité dans config/packages/security.yaml :

yaml
Copier
Modifier
security:
    providers:
        app_user_provider:
            entity:
                class: App\Entity\User
                property: email

    firewalls:
        main:
            pattern: ^/
            form_login:
                login_path: app_login
                check_path: app_login
            logout:
                path: app_logout
                target: /
            remember_me:
                secret: '%kernel.secret%'
                lifetime: 604800
                path: /
            anonymous: true

    access_control:
        - { path: ^/admin, roles: ROLE_ADMIN }
        - { path: ^/employee, roles: ROLE_EMPLOYEE }
        - { path: ^/profile, roles: ROLE_USER }


        
2. Sécurisation du Frontend
Protection des Pages Frontend
Les pages frontend (Vue.js ou autre framework JS) sont sécurisées en vérifiant si le JWT est présent dans les cookies ou le local storage de l'utilisateur. Lors de chaque requête API, le token JWT est inclus dans l'entête Authorization sous le format Bearer <token>.

Protection des Formulaires et Actions Sensibles
Les formulaires (comme l'inscription et la modification des données) sont sécurisés en utilisant des tokens CSRF (Cross-Site Request Forgery) pour prévenir les attaques CSRF. Symfony offre un mécanisme de protection intégré contre ces attaques.

Session Utilisateur et Stockage du Token JWT
Le token JWT est stocké dans le localStorage ou dans des cookies sécurisés pour les sessions utilisateur. Pour éviter les attaques XSS (Cross-Site Scripting), il est recommandé d'utiliser HttpOnly et Secure dans les cookies pour empêcher l'accès au token depuis le JavaScript.

3. Authentification Frontend avec JWT
Le frontend communique avec le backend en envoyant le token JWT dans l'entête de chaque requête HTTP nécessitant une authentification. Exemple de code JavaScript pour envoyer une requête sécurisée avec un token :

const token = localStorage.getItem('jwt_token');

fetch('https://localhost/api/vehicles', {
  method: 'GET',
  headers: {
    'Authorization': `Bearer ${token}`,
    'Content-Type': 'application/json'
  }
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error('Error:', error));



Fonctionnalités de l'Application

1. Page d'Accueil
Page principale du site présentant le garage, ses services et les petites annonces de véhicules disponibles à la vente.

2. Pages d'Inscription et de Connexion
Les utilisateurs peuvent créer un compte et se connecter. Les administrateurs et employés ont des accès spécifiques basés sur des rôles.

3. Interface Administrateur
Accessible uniquement aux administrateurs, cette interface permet de gérer les utilisateurs, les annonces de voitures, et les services proposés par le garage via EasyAdmin.

4. Interface Employé
Les employés peuvent gérer les petites annonces (CRUD) et les tâches spécifiques du garage.

5. Page des Services
Affichage des services proposés par le garage : mécanique, entretien, carrosserie.

6. Page des Petites Annonces
Liste des voitures mises en vente, avec des détails et des photos.




Tests avec PHPUnit

1. Installation de PHPUnit
Installez PHPUnit dans votre environnement Docker pour exécuter des tests unitaires :
composer require --dev phpunit/phpunit

2. Exemple de Test Unitaire
Voici un exemple de test unitaire pour vérifier que l'authentification fonctionne correctement :

// tests/Controller/SecurityControllerTest.php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    public function testLoginFailure()
    {
        $client = static::createClient();
        $client->request('POST', '/api/login', [], [], [], json_encode(['email' => 'wrong@example.com', 'password' => 'wrongpassword']));
        $this->assertResponseStatusCodeSame(401);
    }

    public function testLoginSuccess()
    {
        $client = static::createClient();
        $client->request('POST', '/api/login', [], [], [], json_encode(['email' => 'valid@example.com', 'password' => 'validpassword']));
        $this->assertResponseStatusCodeSame(200);
        $this->assertJsonContains(['token']);
    }
}





Tests avec Postman
Introduction aux Tests avec Postman
Postman est un outil populaire pour tester les APIs HTTP. Il permet de simuler des requêtes HTTP et de vérifier les réponses de votre backend, ce qui est essentiel pour s'assurer que les endpoints de votre application fonctionnent correctement. Dans cette section, nous allons expliquer comment configurer Postman pour tester les principales fonctionnalités de votre application, notamment l'authentification et les endpoints de gestion des annonces.

Tests des APIs d'Authentification avec JWT
Test de Connexion (Login)
Requête POST pour la connexion :



{
  "email": "valid@example.com",
  "password": "validpassword"
}


Réponse attendue :
{
  "token": "votre_token_jwt"
}



Test de Connexion Échouée (Login)
Requête POST pour la connexion échouée :

{
  "email": "wrong@example.com",
  "password": "wrongpassword"
}


Réponse attendue :
{
  "message": "Invalid credentials"
}


Tests des APIs de Gestion des Annonces
Test d'Ajout d'une Annonce (POST)
Requête POST pour l'ajout d'une annonce :
{
  "title": "Ford Mustang 2023",
  "price": 30000,
  "description": "Véhicule en excellent état",
  "year": 2023,
  "brand": "Ford",
  "model": "Mustang",
  "mileage": 5000
}



Réponse attendue :
{
  "id": 123,
  "title": "Ford Mustang 2023",
  "price": 30000,
  "description": "Véhicule en excellent état",
  "year": 2023,
  "brand": "Ford",
  "model": "Mustang",
  "mileage": 5000
}



Test de Récupération des Annonces (GET)
Requête GET pour récupérer toutes les annonces :
Réponse attendue :
[
  {
    "id": 123,
    "title": "Ford Mustang 2023",
    "price": 30000,
    "description": "Véhicule en excellent état",
    "year": 2023,
    "brand": "Ford",
    "model": "Mustang",
    "mileage": 5000
  },
  {
    "id": 124,
    "title": "Chevrolet Camaro 2022",
    "price": 28000,
    "description": "Véhicule neuf",
    "year": 2022,
    "brand": "Chevrolet",
    "model": "Camaro",
    "mileage": 0
  }
]




Test de Suppression d'une Annonce (DELETE)
Réponse attendue :
{
  "message": "Annonce supprimée"
}







Conclusion
Ce projet de gestion de garage automobile représente un système complet qui répond aux besoins de sécurité, d'authentification, et de gestion des véhicules et services. Les fonctionnalités de l'application sont sécurisées par l'utilisation de JWT pour l'authentification, ainsi que de contrôles d'accès basés sur les rôles (administrateur, employé, client). De plus, le backend est testé de manière unitaire avec PHPUnit, et les APIs sont testées avec Postman pour garantir leur bon fonctionnement.


















