<?php
header('X-Frame-Options:DENY'); // クリックジャッキング対策

// 定数ファイル読み込み
require_once '../conf/const.php';
// DB接続用関数ファイル読み込み
require_once MODEL_PATH . 'db.php';
// 汎用関数ファイル読み込み
require_once MODEL_PATH . 'functions.php';
// TOPページ用関数ファイル読み込み
require_once MODEL_PATH . 'top.php';
// 情報登録用関数ファイル読み込み
require_once MODEL_PATH . 'add_info.php';


// session開始
session_start();

// CSRF対策
$token = get_csrf_token();

// GETパラメータを確認し、空っぽならmainページへリダイレクト
if(get_get('h') === ''){
    header('Location: main.php');
    exit;
}; 
// topページのクライアントソースファイル読み込み
include_once VIEW_PATH . 'complete_view.php';