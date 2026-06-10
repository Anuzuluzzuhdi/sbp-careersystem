# 1. Gunakan 'image' PHP resmi dengan Apache
FROM php:8.3-apache

# 2. Instal alat pendukung, ekstensi PHP, dan Node.js (untuk Vite)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    && curl -sL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql gd

# 3. Aktifkan mod_rewrite Apache (Wajib untuk routing Laravel)
RUN a2enmod rewrite

# 4. Arahkan Document Root Apache ke folder /public milik Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 5. Copy semua file projek dari laptop ke dalam kontainer server
COPY . /var/www/html

# 6. Instal Composer & Laravel Packages
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# 7. Build aset Frontend menggunakan Vite secara otomatis
RUN npm install && npm run build

# 8. Berikan izin akses folder storage & cache (Biar ga Error 500 Permission Denied)
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 9. Buka port 80 untuk akses web
EXPOSE 80