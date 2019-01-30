<?php

require('dbconnect.php');

//消去する投稿IDを取得
$feed_id = $_GET['feed_id'];

//削除
//DELETE FROM テーブル WHERE
$sql = 'DELETE FROM `feeds`WHERE`id` = ?';
$data = [$feed_id];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

header("Location: timeline.php");
exit();