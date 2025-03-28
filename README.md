# README

## Prérequis

- **PHP 8.3**  
- **Composer**  
- (Optionnel) Une base de données MariaDB/MySQL configurée

## Installation

1. **Initaliser la base de données :**
   ```bash
   docker compose up
   ```
2. **Installer les dépendances :**
   ```bash
   composer install
   ```
3. **Configurer la base de données (si nécessaire) :**  
   Mettez à jour votre fichier `bootstrap/doctrine.php` avec vos identifiants DB.

4. **Mettre à jour le schéma :**
   ```bash
   php cli-create-schema.php
   ```
   (Ce script utilise l’EntityManager pour créer ou mettre à jour la base de données en fonction de vos entités.)

## Commandes disponibles

### 1. Créer une flotte

```bash
php bin/console.php fleet:create <userId>
```
- **userId** : Identifiant de l’utilisateur pour lequel on crée la flotte.

**Exemple :**
```bash
php bin/console.php fleet:create user123
```
Sortie possible :
```
Flotte créée avec l'ID : a1b2c3d4-e5f6-7a89-b0c1-d2e3f4a5b6c7
```

---

### 2. Enregistrer un véhicule

```bash
php bin/console.php fleet:register-vehicle <fleetId> <vehiclePlateNumber>
```
- **fleetId** : Identifiant de la flotte (fourni lors de la création).
- **vehiclePlateNumber** : Plaque d’immatriculation du véhicule.

**Exemple :**
```bash
php bin/console.php fleet:register-vehicle a1b2c3d4-e5f6-7a89-b0c1-d2e3f4a5b6c7 ABC123
```
Sortie possible :
```
Véhicule enregistré avec succès.
```

---

### 3. Localiser un véhicule

```bash
php bin/console.php fleet:localize-vehicle <fleetId> <vehiclePlateNumber> <lat> <lng> [alt]
```
- **fleetId** : Identifiant de la flotte.
- **vehiclePlateNumber** : Plaque d’immatriculation du véhicule.
- **lat** : Latitude (ex. 48.8566).
- **lng** : Longitude (ex. 2.3522).
- **alt** : (Optionnel) Altitude.

**Exemple (sans altitude) :**
```bash
php bin/console.php fleet:localize-vehicle a1b2c3d4-e5f6-7a89-b0c1-d2e3f4a5b6c7 ABC123 48.8566 2.3522
```
Sortie possible :
```
Véhicule localisé avec succès.
```

---

## Outils d’analyse et de tests

### 1. PHPStan

Pour analyser statiquement votre code, exécutez :

```bash
vendor/bin/phpstan analyse --level=7
```

> Ajustez le niveau (`--level`) selon vos besoins.

---

### 2. Tests BDD (Behat)

Les scénarios Gherkin se trouvent généralement dans le dossier `features/`. Pour lancer les tests :

```bash
vendor/bin/behat
```

---

## Intégration Continue (CI)

Un exemple de workflow GitHub Actions est fourni dans `.github/workflows/ci.yml`, qui exécute **PHPStan** et **Behat** sur chaque *pull request* vers `master`. Vous pouvez l’adapter à vos besoins.
