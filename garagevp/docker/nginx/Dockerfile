FROM nginx:alpine

# # Cr?ation du dossier SSL avec les bonnes permissions
# RUN mkdir -p /etc/ssl/private && \
#     chmod 750 /etc/ssl/private

# # Script d'entr?e personnalis?
# COPY docker-entrypoint.sh /usr/local/bin/
# RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# RUN apk add --no-cache openssl

# ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
# CMD ["nginx", "-g", "daemon off;"]

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