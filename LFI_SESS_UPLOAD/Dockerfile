FROM php:7.4-apache

RUN echo 'session.upload_progress.enabled = On\n\
session.upload_progress.cleanup = On\n\
session.upload_progress.prefix = "upload_progress_"\n\
session.upload_progress.name = "PHP_SESSION_UPLOAD_PROGRESS"\n\
session.use_strict_mode = Off\n\
session.save_path = "/var/lib/php/sessions"' > /usr/local/etc/php/conf.d/custom.ini

RUN mkdir -p /var/lib/php/sessions && \
    chown -R www-data:www-data /var/lib/php/sessions && \
    chmod 1733 /var/lib/php/sessions

RUN echo '<?php include($_GET["file"]); ?>' > /var/www/html/index.php

EXPOSE 80
