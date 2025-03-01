FROM php:8.1-apache

# 必要な PHP 拡張をインストール
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install \
    intl \
    zip \
    mysqli \
    pdo \
    pdo_mysql

# Composer のインストール
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# CakePHP 用の mod_rewrite を有効化
RUN a2enmod rewrite

# Apache の設定を修正（AllowOverride All）
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# 作業ディレクトリを /var/www/html に指定
WORKDIR /var/www/html

# ポート 80 を公開
EXPOSE 80
