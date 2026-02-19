FROM php:7.4-apache

COPY index.php /var/www/html/

RUN mkdir -p /var/www/html/sandbox
RUN chmod 777 /var/www/html/sandbox


RUN echo "sys_temp_dir = /var/www/html/sandbox" > /usr/local/etc/php/conf.d/temp.ini
RUN echo "upload_tmp_dir = /var/www/html/sandbox" >> /usr/local/etc/php/conf.d/temp.ini

RUN echo "<Directory /var/www/html/sandbox>\n\tOptions +Indexes\n</Directory>" > /etc/apache2/conf-available/sandbox.conf
RUN a2enconf sandbox

EXPOSE 80

