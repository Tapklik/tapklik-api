FROM tapklik/composer-base:v1.0.0
VOLUME /tmp

COPY . /var/www/html/api.tapklik.com/
WORKDIR /var/www/html/api.tapklik.com
RUN ls
RUN composer install
RUN cp .env.example .env
RUN php artisan key:generate
CMD chown -R www-data public/trunk
CMD chown -R www-data storage bootstrap/cache
CMD chmod -R ug+rwx storage bootstrap/cache

WORKDIR /etc/apache2/sites-available
RUN sed -i 's/{{SERVICE}}/api.tapklik.com/g' 000-default.conf
RUN a2dissite 000-default.conf
RUN a2ensite 000-default.conf

ENTRYPOINT ["apache2ctl","-D", "FOREGROUND"]
