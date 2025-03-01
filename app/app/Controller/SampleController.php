<?php
class SampleController extends AppController {
    public $name = 'Sample';

    public function index() {
        // PHP 5 特有の関数をいくつか使用する
        $date = '2025-03-01';
        
        // PHP 5 の strtotime を使用
        $timestamp = strtotime($date);
        $this->set('timestamp', $timestamp);
        
        // PHP 5 の ereg 関数（非推奨）
        $regexResult = ereg('^[0-9]{4}-[0-9]{2}-[0-9]{2}$', $date);
        $this->set('regexResult', $regexResult);
        
        // PHP 5 の split 関数（非推奨）
        $splitResult = split('-', $date);
        $this->set('splitResult', $splitResult);
        
        // PHP 5 の mysql_connect（非推奨）
        $conn = mysql_connect('localhost', 'root', 'password');
        $this->set('mysqlConn', $conn);
        
        // PHP 5 の get_magic_quotes_gpc（非推奨）
        $magicQuotes = get_magic_quotes_gpc();
        $this->set('magicQuotes', $magicQuotes);
        
        // PHP 5 の register_globals（セキュリティリスク）
        $globals = $GLOBALS;
        $this->set('globals', $globals);
    }
}
