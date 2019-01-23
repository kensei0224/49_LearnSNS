<?php
session_start();
//サインアウト処理
//1セッションを空にする

//SESSON変数んはき
//ブラウザのセッションをからにする
$_SESSION = [];

session_destroy();
//2サインイン画面に遷移する

header("Location: signin.php");
exit();
