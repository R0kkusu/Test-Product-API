# API de gestion des produits avec Symfony

Il s'agit d'une API RESTful développée avec Symfony pour gérer des produits. L'API permet de créer, récupérer, modifier et supprimer des produits dans une base de données MySQL.

## Table des matières

- [Installation](#installation)
- [Lancer l'API](#lancer-lapi)
- [Endpoints de l'API](#endpoints-de-lapi)
- [Tester l'API avec Postman](#tester-lapi-avec-postman)

## Installation

### Prérequis

Assurez-vous d'avoir installé les éléments suivants :

- PHP 8.0 ou supérieur
- Composer
- MySQL
- Symfony CLI (optionnel)

### Étapes

1. **Installer les dépendances :**
   Exécutez Composer pour installer les paquets nécessaires :

```bash
   composer install
```

2. **Configurer l'environnement :**
   Ouvrir le fichier `.env` et configurez la connexion à la base de données. Voici un exemple pour MySQL :

   DATABASE_URL="mysql://username:password@127.0.0.1:3306/nom_de_bdd?serverVersion=8&charset=utf8mb4"

3. **Créer la base de données :**
   Exécutez les commandes suivante pour créer la base de données et les tables nécessaires :

```bash
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
```

## Lancer l'API

### Mode développement

Pour démarrer l'API en mode développement :

```bash
symfony server:start
```

Ou utilisez le serveur intégré de PHP :

```bash
php -S 127.0.0.1:8000 -t public
```

Votre API sera accessible à `http://127.0.0.1:8000`.

## Endpoints de l'API

| Ressource         | POST                     | GET                         | PATCH                           | DELETE               |
| ----------------- | ------------------------ | --------------------------- | ------------------------------- | -------------------- |
| **/products**     | Créer un nouveau produit | Récupérer tous les produits | X                               | X                    |
| **/products/:id** | X                        | Récupérer un produit par ID | Modifier un produit s'il existe | Supprimer un produit |

### Exemple de payload pour la création/modification de produit

```json
{
  "code": "PRD123",
  "name": "Produit 1",
  "description": "Un produit d'exemple",
  "image": "product1.png",
  "category": "Électronique",
  "price": 100.0,
  "quantity": 10,
  "internalReference": "REF001",
  "shellId": 1,
  "inventoryStatus": "INSTOCK",
  "rating": 4.5
}
```

## Tester l'API avec Postman

1. **Créer une nouvelle collection :**

   - Ouvrez Postman et cliquez sur **Collections**.
   - Cliquez sur **+ Nouvelle Collection** et nommez-la "API Produits".

2. **Configurer les requêtes :**
   Pour chaque endpoint, créez une nouvelle requête dans Postman :

   - **POST /products**

     - Méthode : `POST`
     - URL : `http://127.0.0.1:8000/products`
     - Corps : Choisir **raw** et le format **JSON**, puis fournir les données du produit.

   - **GET /products**

     - Méthode : `GET`
     - URL : `http://127.0.0.1:8000/products`

   - **GET /products/:id**

     - Méthode : `GET`
     - URL : `http://127.0.0.1:8000/products/{id}`

   - **PATCH /products/:id**

     - Méthode : `PATCH`
     - URL : `http://127.0.0.1:8000/products/{id}`
     - Corps : Fournir les données du produit à modifier.

   - **DELETE /products/:id**
     - Méthode : `DELETE`
     - URL : `http://127.0.0.1:8000/products/{id}`

3. **Envoyer les requêtes et vérifier les réponses :**
   - Envoyez les requêtes une par une et vérifiez que vous recevez les réponses correctes avec les codes de statut appropriés.
