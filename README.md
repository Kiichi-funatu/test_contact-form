# # アプリケーション名
お問い合わせフォームアプリ（Laravel × Docker）

## 概要
ユーザーが問い合わせ内容を送信し、管理者が内容を確認できるシンプルな問い合わせ管理アプリです。

---

## 環境構築

### 1. リポジトリのクローン
- git clone git@github.com:yukit4mu/test_contact-form.git
### Dockerビルド
- docker-compose up -d --build
### Laravel環境構築
- docker-compose exec php bash
- composer install
- cp .env.example .env , 環境変数を適宜変更
- php artisan key:generate
- php artisan migrate
- php artisan db:seed

## 開発環境
  - お問い合わせ画面：http://localhost/  
  - ユーザー登録: http://localhost/register  
  - phpMyAdmin：http://localhost:8080/

## 使用技術(実行環境)
- PHP 8.2.11
- Laravel 8.83.8
- MySQL 8.0.26
- nginx 1.21.1

## ER図
![ER図](docs/erd.png)