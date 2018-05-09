FROM tapklik/composer-base:v1.0.0

WORKDIR /etc/apache2/sites-available
RUN sed -i 's/{{SERVICE}}/api.tapklik.com/g' 000-default.conf
RUN a2dissite 000-default.conf
RUN a2ensite 000-default.conf

COPY . /var/www/html/api.tapklik.com/

WORKDIR /var/www/html/api.tapklik.com
RUN composer install \
	&& cp .env.example .env \
	&& php artisan key:generate \
	&& mkdir public/trunk \
	&& chown -R www-data:www-data public/trunk \
	&& chown -R www-data bootstrap/cache \
	&& chown -R www-data storage \
	&& ls -ll

ENTRYPOINT ["apache2ctl","-D", "FOREGROUND"]
