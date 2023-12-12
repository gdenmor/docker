FROM mariadb:latest

# Establecer la contraseña de root
ENV MARIADB_ROOT_PASSWORD=root

# Copiar el script init.sql al directorio de inicialización
COPY examen.sql /docker-entrypoint-initdb.d
