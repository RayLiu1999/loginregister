<?php
require_once('./connect/connect.php');
try {
    $error = '';
    if (isset($_POST['submit'])) {

        $username = htmlspecialchars($_POST['username'], ENT_QUOTES);
        if (!$username) {
            throw new Exception('請輸入使用者名稱');
        }

        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        if (!$email) {
            throw new Exception('輸入的信箱格式有誤');
        }

        $password = filter_input(INPUT_POST, 'password');
        $confirm_password = $_POST['confirm_password'];
        if ($password !== $confirm_password) {
            throw new Exception('兩次密碼不相同');
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT, ['COST' => 12]);
        if ($passwordHash  === false) {
            throw new Exception('密碼有問題');
        }

        $sql = $conn->prepare("SELECT * FROM users WHERE user_name =? OR email = ? OR password = ?");  // 這邊找prepare和execute都只差在變數不一定而已，所以可以寫成class的method帶參數
        $sql->execute(array($username, $email, $passwordHash));
        if (empty($sql->fetchAll())) {
            $sql = $conn->prepare("INSERT INTO users(user_name, email, password) VALUES(?, ?, ?)");
            $sql->execute(array($username, $email, $passwordHash));
            header('Location:index.php');
            exit();
        } else {
            throw new Exception('此帳號已被註冊');
        }
    };
} catch (Exception $e) {
    $error = $e->getMessage();
}


?>

<?php require('./layouts/header.php') ?>

<form method="POST" action="signup.php">
    <div class="container">
        <div class="row justify-content-center" style="padding-top: 50px">
            <div class="card" style="width: 24rem">
                <div class="card-body">
                    <div class="card-title ">
                        <h2 class="d-flex justify-content-center">會員註冊</h2>
                    </div>
                    <div class="form-group">
                        <label for="username">使用者名稱</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="請輸入名稱" autocomplete="off">
                        <?php echo stristr($error, '使用者') ? '<h6 class="text-danger">' . $error . '</h6>' : ''; ?>
                    </div>
                    <div class="form-group">
                        <label for="email">電子信箱</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="請輸入電子信箱" autocomplete="off">
                        <?php echo stristr($error, '信箱') ? '<h6 class="text-danger">' . $error . '</h6>' : ''; ?>

                    </div>
                    <div class="form-group">
                        <label for="password">密碼</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="請輸入密碼">
                        <?php echo stristr($error, '密碼') ? '<h6 class="text-danger">' . $error . '</h6>' : ''; ?>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">確認密碼</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="請再一次輸入密碼">
                        <?php echo stristr($error, '兩次') ? '<h6 class="text-danger">' . $error . '</h6>' : ''; ?>
                    </div>
                    <button class="btn btn-secondary" type="submit" name="submit">註冊</button>
                </div>
            </div>
        </div>
    </div>
</form>

<?php require('./layouts/footer.php') ?>