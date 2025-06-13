# 家計簿アプリケーション

## 概要
このアプリケーションは、日々の支出を記録し、月次レポートを生成する家計簿アプリケーションです。

## 機能
- 支出の登録・削除
- カテゴリー別の支出集計
- 月次レポートの表示
- 過去6ヶ月の支出推移グラフ

## 開発環境
- PHP 8.2以上
- Laravel 12.x
- MySQL 8.0
- Tailwind CSS
- Docker
- Docker Compose

## セットアップ
1. リポジトリをクローン
```bash
git clone [リポジトリURL]
```

2. 依存関係のインストール
```bash
composer install
```

3. 環境設定
```bash
cp .env.example .env
php artisan key:generate
```

4. Dockerコンテナの起動
```bash
docker compose up -d
```

5. データベースのセットアップ
```bash
# セッションテーブルの作成
php artisan session:table

# マイグレーションの実行
php artisan migrate:fresh --seed
```

6. 開発サーバーの起動
```bash
# サーバーの起動
./vendor/bin/sail up -d

# サーバーの停止
./vendor/bin/sail down
```

7. アプリケーションへのアクセス
ブラウザで以下のURLにアクセスしてください：
```
http://localhost
```

## テストユーザー
以下のユーザーでログインできます：

### 管理者ユーザー
- メールアドレス: admin@example.com
- パスワード: password

### テストユーザー
- メールアドレス: test@example.com
- パスワード: password

## テスト実行
以下のコマンドでテストを実行できます：

```bash
# すべてのテストを実行
./vendor/bin/sail test

# 特定のテストファイルのみ実行
./vendor/bin/sail test tests/Feature/ExpenseTest.php

# 特定のテストメソッドのみ実行
./vendor/bin/sail test --filter test_can_create_expense

# テストカバレッジレポートの生成
./vendor/bin/sail test --coverage
```

## ライセンス
MITライセンス
