# 家計簿アプリケーション

Laravelを使用したシンプルな家計簿アプリケーションです。PHPUnitの学習を目的として作成されています。

## 機能

- 支出の登録（金額、日付、カテゴリー、説明）
- 支出の一覧表示
- 支出の削除
- ユーザー認証（ログイン必須）

## 環境要件

- Docker
- Docker Compose
- PHP 8.4以上
- Composer

## 環境構築手順

1. リポジトリのクローン
```bash
git clone git@github.com:Kenshu-Miura/PHPUnitTest.git
cd PHPUnitTest
```

2. 依存関係のインストール
```bash
composer install
```

3. 環境設定ファイルの作成
```bash
cp .env.example .env
```

4. アプリケーションキーの生成
```bash
./vendor/bin/sail artisan key:generate
```

5. データベースのマイグレーション
```bash
./vendor/bin/sail artisan migrate
```

6. アプリケーションの起動
```bash
./vendor/bin/sail up -d
```

これで http://localhost にアクセスしてアプリケーションを使用できます。

## 使い方

### 支出の登録
1. トップページの「支出を登録」フォームに以下の情報を入力
   - 金額（必須）
   - 日付（必須）
   - カテゴリー（必須）
   - 説明（必須）
2. 「支出を登録」ボタンをクリック

### 支出の削除
- 支出一覧の各項目にある「削除」ボタンをクリック
- 確認ダイアログで「OK」をクリックすると支出が削除されます

## 開発環境の停止

開発環境を停止する場合は以下のコマンドを実行します：

```bash
./vendor/bin/sail down
```

## テストの実行

PHPUnitを使用したテストを実行する場合は以下のコマンドを実行します：

```bash
./vendor/bin/sail artisan test
```

## 注意事項

- `.env`ファイルはGit管理されていません。新規環境構築時は`.env.example`をコピーして使用してください。
- データベースの接続情報は`.env`ファイルで設定されています。必要に応じて変更してください。
