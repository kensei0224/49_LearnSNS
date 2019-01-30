<?php

session_start();
require('dbconnect.php');

//サインインしていなければsignin.phpへ強制遷移
if(!isset($_SESSION['49_LearnSNS']['id'])){
    //signin.phpへ強制遷移
    header('Location: signin.php');
    exit();
}

$sql = 'SELECT * FROM `users` WHERE `id` = ?';
$data = [$_SESSION['49_LearnSNS']['id']];
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

$signin_user = $stmt->fetch(PDO:: FETCH_ASSOC);

//->アロー演算子
//インスタンスのマンバメソットを呼び出す
echo'<pre>';
var_dump($signin_user);
echo '</pre>';


///エラー内容を入れておく配列定義
$errors = [];

//投稿ボタンが押されたら
//=POST送信だったら
if (!empty($_POST)){
    //textareの値取り出し
    //$_POSTのキーはtextareタグのname属性を使う
    $feed = $_POST['feed'];

    //投稿が空かどうか
    if($feed != ''){
    //投稿処理
    //INSERT INTO テーブル名(カラム名１、カラム名２)VALUES値１値２

    $sql = 'INSERT INTO `feeds`(`feed`,`user_id`,`created`)VALUES(?,?,NOW())';

    //?に入る値を列挙
    $data = [$feed, $signin_user['id']];
    //実行するSQLを準備
    $stmt = $dbh->prepare($sql);
    //SQL実行
    $stmt->execute($data);

    //投稿しっぱなしになるのを防ぐため
    header('Location: timeline.php');
    exit();
    }else{
        //エラー
        //「feed」が「空」とゆうエラーを入れておく
        $errors['feed'] = 'blank';

    }
}

//投稿情報をすべて取得する
$sql = 'SELECT `f`.*,`u`.`name`,`u`.`img_name`
 FROM `feeds` AS `f`
 LEFT JOIN`users` AS `u`
 ON `f`. `user_id` = `u`.`id`
 ORDER BY `f`.`created` DESC';
$stmt = $dbh->prepare($sql);
$stmt->execute();


//投稿情報を入れておく配列定義
 $feeds = [];
 while (true){
    //fetchは一行取得して次にすすむ
    //取得できた場合は連想配列
    //取得できない場合はfalse
    $record = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($record == false){
        break;
    }
    $feeds[] = $record;
 }

 echo '<pre>';
 var_dump($feeds);
 echo '</pre>';



?>


<!-- includ(ファイル名)
指定されたファイルが指定された箇所に読み込まれる
Webサービス内で共通するような場所は他のファイル
で、定義をして、様々なページから利用可能にすべき

inclubeとrequireの違い
プログラム記載にミスがある場合
requireはエラー
inclubeは警告
includeされたファイル内では呼び出し元の変数が利用できる -->



<?php include('layouts/header.php'); ?>
<body style="margin-top: 60px; background: #E4E6EB;">
    <?php include('navbar.php'); ?>
    <div class="container">
        <div class="row">
            <div class="col-xs-3">
                <ul class="nav nav-pills nav-stacked">
                    <li class="active"><a href="timeline.php?feed_select=news">新着順</a></li>
                    <li><a href="timeline.php?feed_select=likes">いいね！済み</a></li>
                </ul>
            </div>
            <div class="col-xs-9">
                <div class="feed_form thumbnail">
                    <form method="POST" action="">
                        <div class="form-group">
                            <textarea name="feed" class="form-control" rows="3" placeholder="Happy Hacking!" style="font-size: 24px;"></textarea><br>
                        </div>
                        <input type="submit" value="投稿する" class="btn btn-primary">
                    </form>
                </div>

                <!-- 
forech 配列の個数分繰り返し処理が行われる
forech(配列 as 取り出した変数)
forech(複数形 as 単数形)

                 -->
                <?php foreach($feeds as $feed):?>


                <div class="thumbnail">
                    <div class="row">
                        <div class="col-xs-1">
                            <img src="user_profile_img/<?php  echo $feed['img_name'];?>" width="40px">
                        </div>
                        <div class="col-xs-11">
                            <a href="profile.php" style="color: #7f7f7f;"><?php  echo $feed['name']; ?></a>
                            2018-10-14
                        </div>
                    </div>
                    <div class="row feed_content">
                        <div class="col-xs-12">
                            <span style="font-size: 24px;"><?php echo $feed['feed'];?></span>
                        </div>
                    </div>
                    <div class="row feed_sub">
                        <div class="col-xs-12">
                            <button class="btn btn-default">いいね！</button>
                            いいね数：
                            <span class="like-count">10</span>
                            <a href="#collapseComment" data-toggle="collapse" aria-expanded="false"><span>コメントする</span></a>
                            <span class="comment-count">コメント数：5</span>
                            <?php if ($feed['user_id'] == $signin_user['id']):?>                            <a href="edit.php" class="btn btn-success btn-xs">編集</a>
                             <a onclick="return confirm('ほんとに消すの？');" href="delete.php?feed_id=<?php echo $feed['id']; ?>" class="btn btn-danger btn-xs">削除</a>
                        <?php endif;?>
                        </div>
                        <?php include('comment_view.php'); ?>
                    </div>
                </div>
            <?php endforeach; ?>
                <div aria-label="Page navigation">
                    <ul class="pager">
                        <li class="previous disabled"><a><span aria-hidden="true">&larr;</span> Newer</a></li>
                        <li class="next disabled"><a>Older <span aria-hidden="true">&rarr;</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
<?php include('layouts/footer.php'); ?>
</html>
