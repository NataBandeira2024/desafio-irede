# FROM php:8.1-fpm

# # Instalar dependências do sistema
# RUN apt-get update && apt-get install -y \
#     libpng-dev \
#     libjpeg-dev \
#     libfreetype6-dev \
#     libicu-dev \
#     libzip-dev \
#     unzip \
#     git \
#     libonig-dev \
#     nodejs \
#     npm
# # Instalar extensões PHP necessárias
# RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
#     && docker-php-ext-install gd \
#     && docker-php-ext-install intl \
#     && docker-php-ext-install zip \
#     && docker-php-ext-install mysqli pdo pdo_mysql

# # Configurar o diretório de trabalho
# WORKDIR /var/www

# # Copiar o Composer para dentro do contêiner
# COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# # Copiar o código-fonte do Laravel
# COPY . .

# # Instalar as dependências do Laravel
# RUN composer install

# # Instalar dependências do Vue.js e construir o frontend
# RUN npm install
# RUN npm run dev

# # Expor a porta 9000 para o PHP-FPM
# EXPOSE 9000

# # Configurar o ponto de entrada para o PHP-FPM
# CMD ["php-fpm"]


# Dockerfile

# Usar a imagem base do PHP 8.1
FROM php:8.1-cli

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libicu-dev \
    libzip-dev \
    unzip \
    git \
    libonig-dev \
    libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install intl \
    && docker-php-ext-install zip \
    && docker-php-ext-install pdo pdo_mysql

# Instalar Node.js e NPM
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest

# Configurar o diretório de trabalho
WORKDIR /var/www

# Copiar o Composer para dentro do contêiner
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copiar o código-fonte do Laravel
COPY . .

# Instalar as dependências do Laravel
RUN composer install
# Instalar dependências do Vue.js e construir o frontend
RUN npm install
RUN npm run dev

# Expor a porta 8000 para o servidor Laravel
EXPOSE 8000

# Comando padrão para iniciar o servidor Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0"]
