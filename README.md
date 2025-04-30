# Immobilus - Plateforme Immobilière

<p align="center">
  <img src="public/frontend/assets/images/logo.png" alt="Immobilus Logo" width="200">
</p>

## Cahier des Charges

### 1. Présentation du Projet

Immobilus est une plateforme immobilière complète permettant la mise en relation entre agents immobiliers et clients potentiels. L'application offre une expérience utilisateur intuitive et des fonctionnalités avancées pour la recherche, la gestion et la visite de biens immobiliers.

### 2. Objectifs

- Créer une plateforme immobilière moderne et réactive
- Faciliter la recherche de biens immobiliers selon divers critères
- Permettre aux agents de gérer efficacement leurs annonces et leurs rendez-vous
- Offrir aux administrateurs une vue d'ensemble et des outils de gestion complets
- Améliorer l'expérience utilisateur grâce à des fonctionnalités interactives

### 3. Public Cible

- **Utilisateurs réguliers** : Personnes à la recherche d'un bien immobilier
- **Agents immobiliers** : Professionnels proposant des biens à la vente ou à la location
- **Administrateurs** : Gestionnaires de la plateforme

### 4. Architecture Technique

- **Framework** : Laravel 10.x
- **Base de données** : MySQL
- **Frontend** : Blade, Bootstrap, JavaScript, jQuery
- **Authentification** : Système multi-rôles (admin, agent, utilisateur)
- **Langues** : Français (principal), anglais (secondaire)

### 5. Fonctionnalités Implémentées

#### 5.1 Système d'Authentification et Gestion des Utilisateurs

- Inscription et connexion des utilisateurs
- Système de rôles (admin, agent, utilisateur)
- Gestion des profils utilisateurs
- Récupération de mot de passe

#### 5.2 Gestion des Propriétés

- Création, modification et suppression d'annonces immobilières
- Catégorisation par types de propriétés
- Gestion des aménités (caractéristiques des biens)
- Système d'images multiples pour chaque propriété
- Statuts des propriétés (disponible, vendu, loué)

#### 5.3 Recherche et Filtrage

- Recherche par mots-clés
- Filtrage par type de propriété, prix, surface, nombre de chambres
- Filtrage par aménités
- Tri des résultats (prix croissant/décroissant, date, etc.)

#### 5.4 Système de Favoris

- Ajout/suppression de propriétés aux favoris
- Liste des favoris par utilisateur
- Gestion des favoris dans le tableau de bord utilisateur

#### 5.5 Système de Messagerie

- Contact direct avec les agents immobiliers
- Historique des conversations
- Notifications de nouveaux messages
- Système de réponses (fil de discussion)

#### 5.6 Système de Rendez-vous

- Prise de rendez-vous pour visiter une propriété
- Gestion des rendez-vous côté agent (confirmation, annulation, etc.)
- Gestion des rendez-vous côté administrateur
- Historique des rendez-vous pour les utilisateurs
- Différents statuts de rendez-vous (en attente, confirmé, annulé, terminé)

#### 5.7 Système de Notifications

- Notifications par email
- Notifications dans l'interface utilisateur
- Notifications pour les changements de statut des rendez-vous
- Notifications pour les nouveaux messages

#### 5.8 Tableaux de Bord et Statistiques

- Tableau de bord administrateur avec statistiques globales
- Tableau de bord agent avec statistiques personnalisées
- Statistiques détaillées sur les rendez-vous
- Graphiques interactifs pour visualiser les données

#### 5.9 Système d'Avis et Évaluations

- Avis sur les propriétés
- Modération des avis par l'administrateur
- Affichage des avis sur les pages de propriétés

### 6. Fonctionnalités à Développer

#### 6.1 Gestion Avancée des Utilisateurs

- Interface d'administration complète pour la gestion des utilisateurs
- Système de vérification des agents immobiliers
- Badges et niveaux pour les utilisateurs actifs

#### 6.2 Recherche Géographique

- Intégration d'une carte interactive
- Recherche par zone géographique
- Affichage des propriétés sur une carte
- Calcul de distances et points d'intérêt à proximité

#### 6.3 Système de Recommandations

- Recommandations de propriétés basées sur l'historique de recherche
- Propriétés similaires sur les pages de détail
- Alertes email pour les nouvelles propriétés correspondant aux critères

#### 6.4 Système de Paiement

- Paiement en ligne pour les services premium
- Mise en avant d'annonces pour les agents
- Abonnements pour les agents immobiliers

#### 6.5 Application Mobile

- Version mobile responsive
- Application native (future évolution)
- Notifications push

### 7. Structure de la Base de Données

- **users** : Informations des utilisateurs et authentification
- **properties** : Détails des biens immobiliers
- **property_types** : Types de propriétés (appartement, maison, etc.)
- **amenities** : Aménités disponibles (piscine, jardin, etc.)
- **property_amenities** : Table pivot pour la relation many-to-many
- **property_images** : Images associées aux propriétés
- **favorites** : Propriétés favorites des utilisateurs
- **property_reviews** : Avis sur les propriétés
- **messages** : Système de messagerie entre utilisateurs
- **appointments** : Rendez-vous pour visiter les propriétés
- **notifications** : Notifications système pour les utilisateurs

### 8. Interfaces Principales

#### 8.1 Frontend

- Page d'accueil avec mise en avant des propriétés
- Page de recherche avec filtres
- Page de détail des propriétés
- Tableau de bord utilisateur
- Tableau de bord agent
- Système de messagerie
- Gestion des rendez-vous
- Gestion des favoris

#### 8.2 Backend (Administration)

- Tableau de bord administrateur
- Gestion des propriétés
- Gestion des types de propriétés
- Gestion des aménités
- Gestion des utilisateurs
- Gestion des rendez-vous
- Statistiques et rapports
- Modération des avis

### 9. Sécurité et Performance

- Authentification sécurisée
- Protection CSRF
- Validation des données
- Optimisation des requêtes SQL
- Mise en cache des données fréquemment utilisées
- Protection contre les injections SQL et XSS

### 10. Déploiement et Maintenance

- Environnement de développement, test et production
- Gestion des versions avec Git
- Sauvegarde régulière de la base de données
- Mises à jour de sécurité
- Surveillance des performances

## Installation et Configuration

### Prérequis

- PHP >= 8.1
- Composer
- MySQL ou MariaDB
- Node.js et NPM (pour les assets)

### Installation

1. Cloner le dépôt
   ```bash
   git clone https://github.com/Jeanos2004/Immobilus.git
   ```

2. Installer les dépendances
   ```bash
   composer install
   npm install
   ```

3. Configurer l'environnement
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Configurer la base de données dans le fichier .env

5. Exécuter les migrations et les seeders
   ```bash
   php artisan migrate --seed
   ```

6. Compiler les assets
   ```bash
   npm run dev
   ```

7. Lancer le serveur
   ```bash
   php artisan serve
   ```

### Comptes par défaut

- **Admin**: admin@immobilus.com / password
- **Agent**: agent@immobilus.com / password
- **Utilisateur**: user@immobilus.com / password

## Licence

Ce projet est sous licence propriétaire. Tous droits réservés.

## Contact

Pour toute question ou suggestion, veuillez contacter l'équipe de développement à l'adresse contact@immobilus.com.
