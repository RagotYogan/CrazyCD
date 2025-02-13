# Utiliser une image de base Node.js
FROM node:18-alpine AS builder

# Définir le répertoire de travail
WORKDIR /app

# Copier les fichiers package.json et package-lock.json
COPY Frontend/GeoQuizzFront/package*.json ./

RUN ls -la ./

# Installer les dépendances
RUN npm install

# Construire le projet Vite
RUN npm run build

# Utiliser une image Nginx pour servir le contenu statique
FROM nginx:alpine

# Copier les fichiers construits depuis l'étape précédente
COPY --from=builder /app/dist /usr/share/nginx/html

# Exposer le port 80
EXPOSE 80

# Démarrer Nginx
CMD ["nginx", "-g", "daemon off;"]