# 🎓 Youdemy - Plateforme de Cours en Ligne 🎓

## **Description du Projet**
Youdemy est une plateforme innovante dédiée à l’apprentissage en ligne, conçue pour offrir une expérience interactive et personnalisée aux étudiants et enseignants. Ce projet s’appuie sur les principes de la Programmation Orientée Objet (POO) et intègre des fonctionnalités avancées pour simplifier la gestion des cours, des utilisateurs et des contenus.

---

## **Objectifs du Projet**
1. Fournir un outil accessible pour les étudiants et enseignants afin de partager et suivre des cours en ligne.
2. Implémenter une architecture robuste basée sur les principes OOP, garantissant modularité et extensibilité.
3. Offrir une interface utilisateur moderne et intuitive avec des fonctionnalités adaptées à chaque rôle.

---

## **Fonctionnalités Clés**

### **Partie Front Office**

#### **Visiteur :**
- Accès au catalogue des cours avec pagination.
- Recherche de cours par mots-clés.
- Création de compte avec choix de rôle (Étudiant ou Enseignant).

#### **Étudiant :**
- Visualisation du catalogue des cours.
- Recherche et consultation des détails des cours (description, contenu, enseignant).
- Inscription aux cours après authentification.
- Accès à une section “Mes cours” regroupant les cours rejoints.

#### **Enseignant :**
- Ajout de cours avec des détails tels que : titre, description, contenu (vidéo/document), tags, et catégorie.
- Gestion des cours : modification, suppression, et consultation des inscriptions.
- Accès à une section “Statistiques” pour suivre les inscriptions et les cours créés.

### **Partie Back Office**

#### **Administrateur :**
- Validation des comptes enseignants.
- Gestion des utilisateurs : activation, suspension ou suppression.
- Gestion des contenus : cours, catégories et tags.
- Insertion en masse de tags.
- Accès à des statistiques globales
  
### **Fonctionnalités Transversales**
- Gestion des relations many-to-many entre les cours et les tags.
- Polymorphisme appliqué dans les méthodes d’ajout et d’affichage des cours.
- Système d’authentification et d’autorisation pour protéger les fonctionnalités sensibles.
- Contrôle d’accès basé sur les rôles utilisateur.

---

## **Technologies Utilisées**

### **Backend**
- **PHP (POO)** : Implémentation des concepts d’encapsulation, héritage et polymorphisme.
- **MySQL** : Gestion des relations relationnelles (one-to-many, many-to-many).
- **PDO** : Gestion centralisée des connexions et requêtes SQL.

### **Frontend**
- **HTML5, TAILWINDCSS** : Structuration et stylisation des pages.
- **JavaScript** : Interactivité et fonctionnalités dynamiques.

### **Outils**
- **GitHub** : Versioning et gestion du projet.
- **Sessions PHP** : Gestion des utilisateurs connectés.

---

## **Installation**

1. **Clonez le dépôt :**
   ```bash
   git clone https://github.com/votre-utilisateur/youdemy.git
   cd youdemy
