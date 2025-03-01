<h1>Sample Page</h1>

<p><strong>Timestamp (strtotime):</strong> <?= $timestamp ?></p>
<p><strong>Regex (ereg):</strong> <?= $regexResult ? 'Match found' : 'No match' ?></p>
<p><strong>Split (split):</strong> <?= implode(', ', $splitResult) ?></p>
<p><strong>MySQL Connection (mysql_connect):</strong> <?= $mysqlConn ? 'Connected' : 'Failed to connect' ?></p>
<p><strong>Magic Quotes (get_magic_quotes_gpc):</strong> <?= $magicQuotes ? 'Enabled' : 'Disabled' ?></p>
<p><strong>Register Globals:</strong> <?= print_r($globals, true) ?></p>
