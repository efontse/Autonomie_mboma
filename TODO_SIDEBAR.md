# Correction sidebar entrepreneuriat

## Objectif
Corriger l'affichage du sidebar sur les pages du module entrepreneuriat pour qu'il soit identique à celui du module formation.

## Pages à corriger
- [ ] entrepreneuriat/index.blade.php
- [ ] entrepreneuriat/mes-annonces.blade.php  
- [ ] entrepreneuriat/mes-projets.blade.php
- [ ] entrepreneuriat/projet-create.blade.php
- [ ] entrepreneuriat/annonce-create.blade.php
- [ ] entrepreneuriat/projet-show.blade.php
- [ ] entrepreneuriat/annonce-show.blade.php
- [ ] entrepreneuriat/annonces.blade.php

## Modifications nécessaires pour chaque page :
1. Ajouter bouton mobile: `<button class="btn-menu-mobile" onclick="ouvrirSidebar()">`
2. Ajouter overlay: `<div class="sidebar-overlay" id="overlay" onclick="fermerSidebar()"></div>`
3. Ajouter les fonctions JS: toggleSubmenu, ouvrirSidebar, fermerSidebar
4. S'assurer que le sidebar est correctement inclus

