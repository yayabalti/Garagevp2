#  FROM nginx:alpine


#  # Installer les outils nécessaires
#  RUN apk add --no-cache openssl

#  # Créer le répertoire pour les certificats SSL
#  RUN mkdir -p /etc/ssl/private

#  # Copier la configuration Nginx
#  COPY conf.d/default.conf /etc/nginx/conf.d/default.conf
#  RUN chmod 644 /etc/nginx/conf.d/default.conf

#  # vérification de santé
#  HEALTHCHECK --interval=30s --timeout=3s \
#      CMD curl -f http://localhost/ || exit 1

#  # Exposer les ports HTTP et HTTPS
#  EXPOSE 80 443

#  # Commande par défaut
#  CMD ["nginx", "-g", "daemon off;"]







FROM nginx:alpine

# Installer les outils nécessaires pour gérer SSL (openssl)
RUN apk add --no-cache openssl curl

# Créer le répertoire pour les certificats SSL
RUN mkdir -p /etc/ssl/private

# Copier la configuration Nginx
COPY conf.d/default.conf /etc/nginx/conf.d/default.conf
RUN chmod 644 /etc/nginx/conf.d/default.conf


# Vérification de la santé
HEALTHCHECK --interval=30s --timeout=3s \
    CMD curl -f https://localhost || exit 1

# Exposer les ports HTTP (80) et HTTPS (443)
EXPOSE 80 443

# Commande par défaut pour démarrer Nginx
CMD ["nginx", "-g", "daemon off;"]







