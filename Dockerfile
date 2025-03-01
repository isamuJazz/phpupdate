FROM php:5.6-apache

# 必要な PHP 拡張をインストール
RUN docker-php-ext-install mysqli pdo pdo_mysql

# CakePHP 用の mod_rewrite を有効化
RUN a2enmod rewrite

RUN docker-php-ext-install mysql

# Apache の設定を修正（AllowOverride All）
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# 作業ディレクトリを /var/www/html に指定
WORKDIR /var/www/html

# ポート 80 を公開
EXPOSE 80
