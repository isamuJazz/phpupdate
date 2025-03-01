<h1>Sample Page (PHP 7 Compatible)</h1>

<p><strong>Timestamp (strtotime):</strong> <?= $timestamp ?></p>
<p><strong>Regex (preg_match):</strong> <?= $regexResult ? 'Match found' : 'No match' ?></p>
<p><strong>Split (explode):</strong> <?= implode(', ', $splitResult) ?></p>
<p><strong>Database Connection:</strong> <?= $mysqlConn ? 'Connected' : 'Using CakePHP Models' ?></p>
<p><strong>Magic Quotes:</strong> <?= $magicQuotes ? 'Enabled' : 'Disabled (Removed in PHP 7)' ?></p>
<p><strong>Globals:</strong> <?= is_array($globals) ? 'Array with ' . count($globals) . ' items' : 'Not available' ?></p>
