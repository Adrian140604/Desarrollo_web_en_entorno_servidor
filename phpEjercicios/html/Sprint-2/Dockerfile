# Usa una imagen oficial de PHP con Apache
FROM php:8.1-apache

# Instala extensiones de PHP necesarias para MySQL y otras dependencias
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copia tu aplicación al directorio raíz de Apache
COPY . /var/www/html/

# Otorga los permisos necesarios
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Configura la variable de entorno PORT que Render usa para exponer el servicio
ENV PORT=80

# Expone el puerto 80 para que Render lo use
EXPOSE 80

# Inicia Apache
CMD ["apache2-foreground"]
