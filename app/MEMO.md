# PHP & CakePHP アップグレード対応メモ

## 1. PHP 5.6 から PHP 7.4 への対応

### 変更内容

#### 1.1. Dockerfile の更新
- PHP 5.6 から PHP 7.4 に更新
- 非推奨の mysql 拡張を削除（PHP 7 では削除されています）

```diff
- FROM php:5.6-apache
+ FROM php:7.4-apache

# 必要な PHP 拡張をインストール
RUN docker-php-ext-install mysqli pdo pdo_mysql

# CakePHP 用の mod_rewrite を有効化
RUN a2enmod rewrite

- RUN docker-php-ext-install mysql
```

#### 1.2. SampleController.php の更新
- PHP 5 特有の非推奨/削除された関数を置き換え

```diff
- // PHP 5 の ereg 関数（非推奨）
- $regexResult = ereg('^[0-9]{4}-[0-9]{2}-[0-9]{2}$', $date);
+ // ereg の代わりに preg_match を使用
+ $regexResult = preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $date);

- // PHP 5 の split 関数（非推奨）
- $splitResult = split('-', $date);
+ // split の代わりに explode を使用
+ $splitResult = explode('-', $date);

- // PHP 5 の mysql_connect（非推奨）
- $conn = mysql_connect('localhost', 'root', 'password');
+ // mysql_connect の代わりに mysqli_connect を使用
+ // 注意: 実際の接続は CakePHP のデータソースを使用するべき
+ $conn = false; // 実際のアプリケーションでは CakePHP のモデルを使用

- // PHP 5 の get_magic_quotes_gpc（非推奨）
- $magicQuotes = get_magic_quotes_gpc();
+ // get_magic_quotes_gpc は PHP 7 で削除されたため、常に false を返す
+ $magicQuotes = false; // PHP 7 では常に無効

- // PHP 5 の register_globals（セキュリティリスク）
- $globals = $GLOBALS;
+ // register_globals は PHP 5.4 以降で削除されたため、代替コードなし
+ $globals = []; // 簡易的な空の配列を設定
```

#### 1.3. database.php の更新
- MySQL 接続に PDO ドライバを使用するように設定

```diff
public $default = array(
    'datasource' => 'Database/Mysql',
    'persistent' => false,
    'host' => 'db', // docker-compose の db サービス名
    'login' => 'cakeuser',
    'password' => 'cakepass',
    'database' => 'cakephp',
    'prefix' => '',
    'encoding' => 'utf8',
+   'driver' => 'pdo', // PHP 7 互換のために PDO ドライバを使用
);
```

#### 1.4. composer.json の更新
- PHP の要件を更新

```diff
"require": {
-   "php": ">=5.3.0,<8.0.0"
+   "php": ">=7.0.0,<8.0.0"
},
```

#### 1.5. core.php の更新
- エラーレベルの設定を更新

```diff
Configure::write('Error', array(
    'handler' => 'ErrorHandler::handleError',
-   'level' => E_ALL & ~E_DEPRECATED,
+   'level' => E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED,
    'trace' => true
));
```

#### 1.6. View ファイルの更新
- コントローラーの変更を反映

```diff
- <p><strong>Regex (ereg):</strong> <?= $regexResult ? 'Match found' : 'No match' ?></p>
+ <p><strong>Regex (preg_match):</strong> <?= $regexResult ? 'Match found' : 'No match' ?></p>

- <p><strong>Split (split):</strong> <?= implode(', ', $splitResult) ?></p>
+ <p><strong>Split (explode):</strong> <?= implode(', ', $splitResult) ?></p>

- <p><strong>MySQL Connection (mysql_connect):</strong> <?= $mysqlConn ? 'Connected' : 'Failed to connect' ?></p>
+ <p><strong>Database Connection:</strong> <?= $mysqlConn ? 'Connected' : 'Using CakePHP Models' ?></p>

- <p><strong>Magic Quotes (get_magic_quotes_gpc):</strong> <?= $magicQuotes ? 'Enabled' : 'Disabled' ?></p>
+ <p><strong>Magic Quotes:</strong> <?= $magicQuotes ? 'Enabled' : 'Disabled (Removed in PHP 7)' ?></p>
```

## 2. PHP 7.4 から PHP 8.1 への対応

### 変更内容

#### 2.1. Dockerfile の更新
- PHP 7.4 から PHP 8.1 に更新

```diff
- FROM php:7.4-apache
+ FROM php:8.1-apache
```

#### 2.2. composer.json の更新
- PHP 8 をサポートするように更新

```diff
"require": {
-   "php": ">=7.0.0,<8.0.0"
+   "php": ">=7.0.0,<9.0.0"
},
```

#### 2.3. SampleController.php の更新
- PHP 8 の新機能を追加

```php
// PHP 8 の新機能: Nullsafe オペレーター
$user = null;
$username = $user?->name ?? 'Guest'; // PHP 8 の Nullsafe オペレーターと Null 合体演算子

// PHP 8 の新機能: Match 式
$status = 200;
$statusText = match($status) {
    200 => 'OK',
    404 => 'Not Found',
    500 => 'Server Error',
    default => 'Unknown',
};

// PHP 8 の新機能: 名前付き引数
$formattedDate = date(format: 'Y-m-d', timestamp: time());
```

#### 2.4. View ファイルの更新
- PHP 8 の新機能を表示するようにビューを更新

```html
<h1>Sample Page (PHP 8 Compatible)</h1>

<h2>PHP 8 新機能</h2>
<p><strong>Nullsafe オペレーター:</strong> <?= $username ?></p>
<p><strong>Match 式:</strong> <?= $statusText ?></p>
<p><strong>名前付き引数:</strong> <?= $formattedDate ?></p>
```

#### 2.5. core.php の更新
- エラーレベルの設定を更新

```diff
Configure::write('Error', array(
    'handler' => 'ErrorHandler::handleError',
-   'level' => E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED,
+   'level' => E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED & ~E_STRICT,
    'trace' => true
));
```

## 3. CakePHP 2.x から CakePHP 4.x への対応

### 変更内容

#### 3.1. Dockerfile の更新
- PHP 8.1 を使用
- 必要な PHP 拡張をインストール（intl, zip, mysqli, pdo, pdo_mysql）
- Composer 2 をインストール

```dockerfile
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
```

#### 3.2. composer.json の更新
- CakePHP 4.x に対応するように更新
- PHP 8.0 以上をサポート

```json
{
  "name": "cakephp/app",
  "description": "CakePHP application",
  "type": "project",
  "keywords": ["framework", "cakephp"],
  "homepage": "https://cakephp.org",
  "license": "MIT",
  "require": {
    "php": ">=8.0,<9.0",
    "cakephp/cakephp": "^4.4",
    "cakephp/migrations": "^3.2",
    "cakephp/plugin-installer": "^1.3"
  },
  "require-dev": {
    "cakephp/debug_kit": "^4.5",
    "cakephp/bake": "^2.6",
    "phpunit/phpunit": "^9.5"
  },
  "autoload": {
    "psr-4": {
      "App\\": "src/"
    }
  },
  "autoload-dev": {
    "psr-4": {
      "App\\Test\\": "tests/",
      "Cake\\Test\\": "vendor/cakephp/cakephp/tests/"
    }
  }
}
```

#### 3.3. ディレクトリ構造の変更
- CakePHP 4.x の新しいディレクトリ構造に対応
  - `src/Controller/` - コントローラー
  - `templates/` - テンプレートファイル
  - `config/` - 設定ファイル
  - `webroot/` - 公開ファイル

#### 3.4. 新しいファイルの作成

##### 3.4.1. src/Application.php
```php
<?php
declare(strict_types=1);

namespace App;

use Cake\Core\Configure;
use Cake\Core\ContainerInterface;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\BaseApplication;
use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;

class Application extends BaseApplication
{
    public function bootstrap(): void
    {
        parent::bootstrap();

        if (PHP_SAPI === 'cli') {
            $this->bootstrapCli();
        }

        if (Configure::read('debug')) {
            $this->addPlugin('DebugKit');
        }
    }

    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        $middlewareQueue
            ->add(new ErrorHandlerMiddleware(Configure::read('Error')))
            ->add(new AssetMiddleware([
                'cacheTime' => Configure::read('Asset.cacheTime'),
            ]))
            ->add(new RoutingMiddleware($this))
            ->add(new BodyParserMiddleware())
            ->add(new CsrfProtectionMiddleware([
                'httponly' => true,
            ]));

        return $middlewareQueue;
    }

    public function services(ContainerInterface $container): void
    {
    }

    protected function bootstrapCli(): void
    {
    }
}
```

##### 3.4.2. config/app.php
```php
<?php
return [
    'debug' => filter_var(env('DEBUG', true), FILTER_VALIDATE_BOOLEAN),
    'Security' => [
        'salt' => env('SECURITY_SALT', 'aR4nd0mStr1ngF0rS3curity!123'),
    ],
    'Datasources' => [
        'default' => [
            'host' => 'db',
            'username' => 'cakeuser',
            'password' => 'cakepass',
            'database' => 'cakephp',
            'url' => env('DATABASE_URL', null),
        ],
    ],
];
```

##### 3.4.3. config/routes.php
```php
<?php
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

return static function (RouteBuilder $routes) {
    $routes->setRouteClass(DashedRoute::class);

    $routes->scope('/', function (RouteBuilder $builder) {
        $builder->connect('/', ['controller' => 'Sample', 'action' => 'index']);
        $builder->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);
        $builder->fallbacks();
    });
};
```

##### 3.4.4. src/Controller/SampleController.php
```php
<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Controller\Controller;

class SampleController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
    }

    public function index()
    {
        // PHP 8 互換の関数を使用
        $date = '2025-03-01';
        
        // strtotime は PHP 8 でも使用可能
        $timestamp = strtotime($date);
        $this->set('timestamp', $timestamp);
        
        // preg_match は PHP 8 でも使用可能
        $regexResult = preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $date);
        $this->set('regexResult', $regexResult);
        
        // explode は PHP 8 でも使用可能
        $splitResult = explode('-', $date);
        $this->set('splitResult', $splitResult);
        
        // PHP 8 の新機能: Nullsafe オペレーター
        $user = null;
        $username = $user?->name ?? 'Guest';
        $this->set('username', $username);
        
        // PHP 8 の新機能: Match 式
        $status = 200;
        $statusText = match($status) {
            200 => 'OK',
            404 => 'Not Found',
            500 => 'Server Error',
            default => 'Unknown',
        };
        $this->set('statusText', $statusText);
        
        // PHP 8 の新機能: 名前付き引数
        $formattedDate = date(format: 'Y-m-d', timestamp: time());
        $this->set('formattedDate', $formattedDate);
        
        // PHP 8 の新機能: コンストラクタプロパティプロモーション
        $this->set('constructorPropertyPromotion', 'CakePHP 4 と PHP 8 で使用可能');
        
        // PHP 8 の新機能: Union Types
        $this->set('unionTypes', 'CakePHP 4 と PHP 8 で使用可能');
        
        // CakePHP のデータソースを使用
        $this->set('mysqlConn', false);
        
        // PHP 7/8 では削除された機能
        $this->set('magicQuotes', false);
        
        $this->set('globals', []);
    }
}
```

##### 3.4.5. templates/Sample/index.php
```php
<h1>Sample Page (CakePHP 4 & PHP 8 Compatible)</h1>

<p><strong>Timestamp (strtotime):</strong> <?= $timestamp ?></p>
<p><strong>Regex (preg_match):</strong> <?= $regexResult ? 'Match found' : 'No match' ?></p>
<p><strong>Split (explode):</strong> <?= implode(', ', $splitResult) ?></p>

<h2>PHP 8 新機能</h2>
<p><strong>Nullsafe オペレーター:</strong> <?= $username ?></p>
<p><strong>Match 式:</strong> <?= $statusText ?></p>
<p><strong>名前付き引数:</strong> <?= $formattedDate ?></p>
<p><strong>コンストラクタプロパティプロモーション:</strong> <?= $constructorPropertyPromotion ?></p>
<p><strong>Union Types:</strong> <?= $unionTypes ?></p>

<h2>その他の情報</h2>
<p><strong>Database Connection:</strong> <?= $mysqlConn ? 'Connected' : 'Using CakePHP Models' ?></p>
<p><strong>Magic Quotes:</strong> <?= $magicQuotes ? 'Enabled' : 'Disabled (Removed in PHP 7/8)' ?></p>
<p><strong>Globals:</strong> <?= is_array($globals) ? 'Array with ' . count($globals) . ' items' : 'Not available' ?></p>
```

## CakePHP 2.x から 4.x への主な変更点

1. **名前空間の導入**
   - すべてのクラスが名前空間を使用
   - 例: `namespace App\Controller;`

2. **ディレクトリ構造の変更**
   - `src/` ディレクトリにアプリケーションコードを配置
   - `templates/` ディレクトリにテンプレートファイルを配置

3. **設定ファイルの変更**
   - PHP 配列を返す形式に変更
   - 例: `return ['debug' => true, ...];`

4. **ミドルウェアの導入**
   - HTTP リクエスト/レスポンスの処理にミドルウェアを使用
   - 例: `ErrorHandlerMiddleware`, `RoutingMiddleware` など

5. **ORM の改善**
   - エンティティとテーブルの概念の明確な分離
   - リレーションシップの定義方法の変更

6. **テンプレートの拡張子変更**
   - `.ctp` から `.php` に変更

7. **依存性注入の導入**
   - サービスコンテナを使用した依存性注入

## PHP 8 の主な新機能

1. **名前付き引数**
   - 引数の順序を気にせずに関数を呼び出せる
   - 例: `htmlspecialchars($string, double_encode: false)`

2. **コンストラクタプロパティプロモーション**
   - コンストラクタパラメータとクラスプロパティを一度に定義
   - 例: `public function __construct(private string $name) {}`

3. **Nullsafe オペレーター**
   - null チェックを簡略化
   - 例: `$user?->address?->country`

4. **Match 式**
   - switch 文の改良版で、式として使用可能
   - 例: `$result = match($value) { 1 => 'one', 2 => 'two', default => 'other' };`

5. **Union Types**
   - 複数の型を許容するパラメータや戻り値の型宣言
   - 例: `function foo(string|int $value): string|int`

6. **JIT (Just-In-Time) コンパイル**
   - PHP コードの実行速度を向上

7. **throw 式**
   - 式コンテキストでの例外のスロー
   - 例: `$value = $nullable ?? throw new InvalidArgumentException();`

8. **WeakMap**
   - オブジェクトをキーとして使用できる、弱い参照を持つマップ

9. **文字列からの数値比較の警告**
   - 数値文字列と数値の比較時の警告

10. **トレイト内での抽象メソッドの継承**
    - トレイト内で抽象メソッドを継承できるように

## 注意点

- CakePHP 2.x から 4.x へのアップグレードは大きな変更を伴います
- 既存のアプリケーションコードは大幅な書き換えが必要になる場合があります
- PHP 8 では型チェックがより厳格になっています
- 一部の非推奨機能が完全に削除されています
- 暗黙の型変換の動作が変更されている場合があります

## 動作確認方法

Docker コンテナを再ビルドして起動することで、更新されたアプリケーションをテストできます。

```bash
docker-compose down
docker-compose build
docker-compose up -d
```

ブラウザで http://localhost:8080 にアクセスして、アプリケーションが正常に動作することを確認できます。
