<?php
session_start();
require('dbconnect.php');
$errors = [];
if (!empty($_POST)) {
    $email = $_POST['input_email'];
    $password = $_POST['input_password'];
    if ($email != '' && $password != ''){
        //正常系
        //両方入力されている時
        //データベースとの照合処理
        

        // 1入力されたメールアドレス「と」一致する登録データを1件DB から取得する
        $sql = 'SELECT* FROM `users` WHERE `email` = ?';
        $data = [$email];
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);
        //$recordはDBの１レコードのあた胃にする
        //形式は連想配列
        //クーはカラムに依存する
        $record = $stmt->fetch(PDO::FETCH_ASSOC);


        

        if($record == false){
            $errors['signin'] = 'failed';
        }
        //認証成功
        //3セッションにユーザーのIDを格納
        $_SESSION['49_LearnSNS']['id'] = $record['id'];

        //4タイムライン画面に遷移
        header('location: timeline.php');
        exit();

        if(password_verify($password,$record['password'])){
        }else{
            //認証失敗
            $errors['signin'] = 'failed';
        }

    }else{
        $errors['signin'] = 'blank';
    }
}



?>
<?php include('layouts/header.php'); ?>
<body style="margin-top: 60px">
    <div class="container">
        <div class="row">
            <div class="col-xs-8 col-xs-offset-2 thumbnail">
                <h2 class="text-center content_header">サインイン</h2>
                <form method="POST" action="signin.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="email">メールアドレス</label>
                        <input type="email" name="input_email" class="form-control" id="email" placeholder="example@gmail.com">
                        <?php if(isset($errors['signin']) && $errors['signin'] == 'blank'): ?>
                            <p class="
                            text-danger">メールアドレスとパスワードを正しく入力してください</p>
                        <?php endif; ?>

                        <?php if(isset($errors['signin']) && $errors['signin'] == 'failed'): ?>
                            <p class="
                            text-danger">サインインに失敗しました</p>
                        <?php endif; ?>

                    </div>
                    <div class="form-group">
                        <label for="password">パスワード</label>
                        <input type="password" name="input_password" class="form-control" id="password" placeholder="4 ~ 16文字のパスワード">
                    </div>
                    <input type="submit" class="btn btn-info" value="サインイン">
                    <span style="float: right; padding-top: 6px;">
                        <a href="index.php">戻る</a>
                    </span>
                </form>
            </div>
        </div>
    </div>
</body>
<?php include('layouts/header.php'); ?>
</html>
