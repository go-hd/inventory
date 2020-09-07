## 在庫管理システム API側

### 言語
- Laravel v5.7.22
- MySQL 5.7

***
### ローカル環境構築
二度目以降は、dockerの起動のみでOK <br>
(必要に応じてcomposer installやmigrateなど実行)

#### Docker起動
[初回]
```
$ docker-compose up -d --build
```
[二度目以降]
```
$ docker-compose up -d
```

#### Laravel初期設定 (Local)
```
// appコンテナに入る
$ docker exec -it inventry_api_app bash
$ composer install
$ cp .env.example .env
$ php artisan key:generate
$ php artisan migrate
$ php artisan db:seed --class=ActualDataSeeder
$ php artisan passport:install
$ php artisan config:cache
```

#### DB接続情報
```
host: 127.0.0.1
user: homestead
password: secret
database: homestead
port: 3306
```


***
### 認証
Laravel Passportを使用

***
### CORS対策
barryvdh/laravel-corsを使用 

***
### 登録したロットの発注の在庫を即時反映したい場合
```
// appコンテナに入る
$ docker exec -it inventry_api_app bash
$ php artisan command:check-lot-ordered-at
```

