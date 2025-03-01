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
