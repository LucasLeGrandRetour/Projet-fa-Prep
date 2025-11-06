# 📦 site JourneeIntegration (front-office & back-office) en architecture MVC

Projet réalisé dans le cadre des AP web en SIO12 SLAM au semestre 1
Ce projet a été développé par l'équipe XXX formée par :

- nom des équipiers,
- nom des équipiers,
- nom des équipiers.

---

## 📌 Sommaire

- [📄 Présentation du projet](#📄-présentation-du-projet)
- [🧱 Architecture MVC](#🧱-architecture-mvc)
- [🗂️ Structure du projet](#🗂️-structure-du-projet)
- [🔄 Cycle de traitement d'une requête](#🔄-cycle-de-traitement-dune-requête)
- [📂 Détails des routes de l'application](#📂-détails-des-routes-de-lapplication)

---

## 📄 Présentation du projet

Ce projet est une application web permettant de **[fonction principale]**.  
Elle permet notamment de consulter :

- les ateliers prévus
- les développeurs de l'application [autres entités]
- les salles (dans une version ultérieure)

## 🧱 Architecture MVC

L'application suit le modèle MVC (Modèle-Vue-Contrôleur).

Chaque couche a un rôle bien défini :

    1. Modèles : gestion des données et interactions avec la base.
    2. Contrôleurs : logique métier et traitement des requêtes.
    3. Vues : affichage dynamique du contenu.

## 🗂️ Structure du projet

**/controleurs** :
Contient les fichiers PHP qui gèrent la logique métier.

- **Exemple** : gestionAteliers.php gère les actions liées aux ateliers (consultation, et peut-être dans le futur : ajout, modification, suppression, etc.).

**/modeles** :
Contient les fichiers PHP qui interagissent avec la base de données.

- **Exemple** : base.php contient les fonctions pour récupérer les développeurs(et peut-être dans le futur : insérer, modifier, supprimer ou ).

**/vues** :
Contient les fichiers PHP qui génèrent le HTML affiché à l'utilisateur.

- **Exemple** : accueil.php définit la page affichée par défaut, et ateliers.php affiche la liste des ateliers.

**/images** :
Contient les images utilisées dans le site

**/css** :
Contient les fichiers CSS pour le style du site.

- **Exemple** : `styleflexbox.css` contient les styles globaux pour le site, notamment la gestion des boîtes flexibles (flexbox).

**configBdd.php** :
Fichier de configuration pour la connexion à la base de données (par exemple, hôte, nom d'utilisateur, mot de passe, nom de la base).

**index.php** :
Point d'entrée principal du site.
Gère le routage en fonction des paramètres de l'URL (?p=...) et appelle les contrôleurs correspondants.

## 🔄 Cycle de traitement d'une requête

```plaintext
Utilisateur → Route → Contrôleur → Modèle → Base de données
                           ↓
                        Vue (HTML)
```

1. **Utilisateur** :
   L'utilisateur effectue une action (par exemple, cliquer sur un bouton ou soumettre un formulaire).
   Routeur (index.php) :

2. Le **routeur** analyse la requête (paramètre `?p=...`) et appelle la fonction correspondante dans le contrôleur.

3. **Contrôleur** :
   Le contrôleur traite la requête, appelle les fonctions du modèle si nécessaire, et prépare les données pour la vue.
   Modèle :

4. **Modèle** :
   Le modèle interagit avec la base de données pour récupérer ou modifier les données.

5. **Vue** :
   La vue génère le HTML en utilisant les données fournies par le contrôleur et l'affiche à l'utilisateur.

**Exemple** :

- **Apropos.php - Liste des développeurs** :

  1. L'utilisateur clique sur le bouton 'A propos' dans la page d'accueil
  2. Le routeur redirigge vers le contrôleur gestionGlobale.php
  3. Le contrôleur analyse la requête (paramètre `?action=...`) et redirige vers le traitement adéquat, ici traitement 'aPropos' qui réalise successivement:
     - la connexion à la base de données.
     - la soumission de la requête d'extraction des données relatives aux développeurs.
     - retourne les données résultat de la requête.
     - appelle la vue apropos.php qui se charge de l'affichage.

## 📂 Détails des routes de l'application

- **`?controleur=general&action=accueil`**  
   **Description** : Affiche la page d'accueil du site.  
   **Traitement** : Charge la vue `accueil.php`.

- **`?controleur=....&action=404`**
  **Description** : Affiche une page d'erreur 404 si la route demandée n'existe pas.
  **Traitement** : Charge la vue 404_vue.php.

- **`?controleur=general&action=aPropos`**  
   **Description** : Affiche la liste des developpeurs  
   **Traitement** :

  - Appelle le traitement `aPropos` dans le contrôleur `gestionGlobale.php`.
  - Cette fonction récupère les données via le modèle `base.php`.
  - Charge la vue `aPropos.php` pour afficher les données.

- **`?controleur=gestionAteliers&action=consultation`**  
  **_A compléter_**
