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
        $username = $user?->name ?? 'Guest'; // PHP 8 の Nullsafe オペレーターと Null 合体演算子
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
