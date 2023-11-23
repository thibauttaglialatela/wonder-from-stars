# wonder-from-stars

Ce site permettant de partager des photos d'étoiles, planétes, galaxies et autres nébuleuses prisent par les utilisateurs. Le site permet également d'aller chercher les images issues de l'API de la NASA.
Fonctionnalités disponible pour un utilisateur enregistré et connecté.
- ajouter d'une photo (à venir)
- Supprimer une de ces photos (à venir)
- noter une photo (à venir)
- ajouter une photo à sa liste de favoris (à venir)
- Ajouter un commentaire à une photo (à venir)

Fonctionnalités disponible pour l'administrateur
- envoie d'une invitation à un futur utilisateur pour qu'il créer son login, son pseudo et son mot de passe
- Valider un commentaire mis par un utilisateur (à venir)
***
Instruction pour installer le projet
1. Cloner le projet
2. Faire une copie du fichier .env et le renommer en .env.local
3. aller sur le site de l'API de la NASA à l'adresse https://api.nasa.gov/ et faire une demande de clé.
4. Ajouter la ligne suivante au fichier .env.local : NASA_API_KEY={LA CLE API}
***
- Pour lancer le projet faire la commande *make start* dans le terminal ce qui va lancer le serveur PHP et les conteneurs Docker
- Pour arréter le projet taper *make stop* pour arréter le serveur local et les conteneurs.
