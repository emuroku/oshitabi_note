<?php
header('X-Frame-Options:DENY'); // クリックジャッキング対策

// 定数ファイル読み込み
require_once '../conf/const.php';
// DB接続用関数ファイル読み込み
require_once MODEL_PATH . 'db.php';
// 汎用関数ファイル読み込み
require_once MODEL_PATH . 'functions.php';

// session開始
session_start();

// CSRF対策
$token = get_csrf_token();

// PDO取得
$db = get_db_connect();

// トラベルid取得

// 



// topページのクライアントソースファイル読み込み
include_once VIEW_PATH . 'top_view.php';
