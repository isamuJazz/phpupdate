# CakePHP E2E Tests with Playwright

このディレクトリには、CakePHP アプリケーションの E2E (End-to-End) テストが含まれています。テストは Playwright を使用して実装されています。

## 前提条件

- Node.js (v14 以上)
- npm または yarn
- Docker と docker-compose（アプリケーションの実行用）

## セットアップ

1. 依存関係をインストールします：

```bash
cd app/tests/e2e
npm install
```

2. Playwright ブラウザをインストールします：

```bash
npx playwright install chromium
```

## アプリケーションの起動

テストを実行する前に、CakePHP アプリケーションが実行されていることを確認してください：

```bash
docker-compose down
docker-compose build
docker-compose up -d
```

アプリケーションは http://localhost:8080 で実行されるはずです。

## テストの実行

テストを実行するには：

```bash
cd app/tests/e2e
npm test
```

または直接 Playwright を実行：

```bash
npx playwright test
```

## テストの内容

テストは以下の内容を検証します：

1. ホームページが正常に読み込まれること
   - ページタイトルの確認
   - 見出しの存在と内容の確認
   - PHP 8 機能セクションの確認
   - エラーメッセージがないことの確認
   - コンソールエラーがないことの確認

2. Sample コントローラーのルートが正常に動作すること
   - ページが正常に読み込まれること
   - 見出しの存在と内容の確認
   - エラーメッセージがないことの確認

## テスト結果

テスト結果は `test-results` ディレクトリに保存されます。スクリーンショットやその他のアーティファクトもここに保存されます。

HTML レポートを表示するには：

```bash
npx playwright show-report
```

## CI/CD との統合

このテストスイートは CI/CD パイプラインに統合できます。GitHub Actions や Jenkins などの CI/CD システムで実行するための設定例は、必要に応じて追加できます。
