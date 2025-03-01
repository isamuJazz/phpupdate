<?php
class SampleController extends AppController {
    public $name = 'Sample';

    public function index() {
        // PHP 7 互換の関数を使用
        $date = '2025-03-01';
        
        // strtotime は PHP 7 でも使用可能
        $timestamp = strtotime($date);
        $this->set('timestamp', $timestamp);
        
        // ereg の代わりに preg_match を使用
        $regexResult = preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $date);
        $this->set('regexResult', $regexResult);
        
        // split の代わりに explode を使用
        $splitResult = explode('-', $date);
        $this->set('splitResult', $splitResult);
        
        // mysql_connect の代わりに mysqli_connect を使用
        // 注意: 実際の接続は CakePHP のデータソースを使用するべき
        $conn = false; // 実際のアプリケーションでは CakePHP のモデルを使用
        $this->set('mysqlConn', $conn);
        
        // get_magic_quotes_gpc は PHP 7 で削除されたため、常に false を返す
        $magicQuotes = false; // PHP 7 では常に無効
        $this->set('magicQuotes', $magicQuotes);
        
        // register_globals は PHP 5.4 以降で削除されたため、代替コードなし
        $globals = []; // 簡易的な空の配列を設定
        $this->set('globals', $globals);
    }
}
