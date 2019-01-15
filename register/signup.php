<?php
//1エラーだった場合になんのエラーだったか保持する$errorsを定義
//2送信されたデータと空文字を比較
//3一致する場合は$errorsにnameをキーにblankという値
//4エラーがある場合エラーメッセージを表示

//1errorsの定義
$errors = [];

// POSTがどうか
if (!empty($_POST)){
    // 2から文字かどうか
    $name = $_POST['input_name'];
    $email = $_POST['input_email'];
    $password = $_POST['input_password'];
    if ($name == ''){
//3 ユーザー名が空である、とゆう情報を
        $errors['name'] = 'blank';
    }
if ($email == ''){
    $errors['email'] = 'blank;'
}
if($password== ''){
    $errors['password'] = 'blank;'

}





?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>Learn SNS</title>
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../assets/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
</head>
<body style="margin-top: 60px">
    <div class="container">
        <div class="row">
            <div class="col-xs-8 col-xs-offset-2 thumbnail">
                <h2 class="text-center content_header">アカウント作成</h2>
                <!-- 
                    まずformタグのmethodとactionを確認
                    signip.phpでバリエーテーションをするので
                    signup.phpの書き換える
                 -->

                <form method="POST" action="signup.php" enctype="signup.php/form-data">
                    <div class="form-group">
                        <label for="name">ユーザー名</label>
                        <!-- 
                            inputタグのナメ属性が_postのキーになる

                         -->
                        <input type="text" name="input_name" class="form-control" id="name" placeholder="山田 太郎"
                            value="">
                            <?php if (isset($errors['name'])&& $errors['name'] == 'blank'):
                            ?>
                            <p class="text-danger">ユーザー名を入力してください</p>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="email">メールアドレス</label>
                        <?php if (isset($errors['email']) && $errors['email'] == 'blank'):
                            ?>
                            <p class="text-danger">パスワードを入力してください</p>
                        <?php endif; ?>


                        <input type="email" name="input_email" class="form-control" id="email" placeholder="example@gmail.com"
                            value="">
                    </div>
                    <div class="form-group">
                        <label for="password">パスワード</label>
                        <input type="password" name="input_password" class="form-control" id="password" placeholder="4 ~ 16文字のパスワード">
                    </div>
                    <div class="form-group">
                        <label for="img_name">プロフィール画像</label>
                        <input type="file" name="input_img_name" id="img_name" accept="image/*">
                    </div>
                    <input type="submit" class="btn btn-default" value="確認">
                    <span style="float: right; padding-top: 6px;">ログインは
                        <a href="../signin.php">こちら</a>
                    </span>
                </form>
            </div>
        </div>
    </div>
</body>
<script src="../assets/js/jquery-3.1.1.js"></script>
<script src="../assets/js/jquery-migrate-1.4.1.js"></script>
<script src="../assets/js/bootstrap.js"></script>
</html>