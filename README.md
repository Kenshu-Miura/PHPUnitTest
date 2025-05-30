# 家計簿アプリケーション

## 概要
このアプリケーションは、日々の支出を記録し、月次レポートを生成する家計簿アプリケーションです。

## 機能
- 支出の登録・削除
- カテゴリー別の支出集計
- 月次レポートの表示
- 過去6ヶ月の支出推移グラフ

## 開発環境
- PHP 8.1以上
- Laravel 10.x
- SQLite
- Tailwind CSS

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

4. データベースのセットアップ
```bash
php artisan migrate:fresh --seed
```

5. 開発サーバーの起動
```bash
php artisan serve
```

## テストユーザー
以下のユーザーでログインできます：

### 管理者ユーザー
- メールアドレス: admin@example.com
- パスワード: password

### テストユーザー
- メールアドレス: test@example.com
- パスワード: password

## ライセンス
MITライセンス
