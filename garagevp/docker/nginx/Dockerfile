FROM nginx:alpine


# Installer les outils nécessaires
RUN apk add --no-cache openssl

# Créer le répertoire pour les certificats SSL
RUN mkdir -p /etc/ssl/private

# Copier la configuration Nginx
COPY conf.d/default.conf /etc/nginx/conf.d/default.conf
RUN chmod 644 /etc/nginx/conf.d/default.conf

# Exposer les ports HTTP et HTTPS
EXPOSE 80 443

# Commande par défaut
CMD ["nginx", "-g", "daemon off;"]