<?php
require_once('./connect/connect.php');
try {
    $error = '';
    if (isset($_SESSION['logged_in'])) {
        header('location:index.php');
        exit();
    }

    if (isset($_POST['submit'])) {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');

        $sql = $conn->query("SELECT * FROM users WHERE email='$email'");
        foreach ($sql->fetchAll() as $row) {
            $_SESSION['id'] = $row['id'];       // session個別存取比較好，存取都方便
            $_SESSION['username'] = $row['user_name'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['password'] = $row['password'];
        }
        if (!isset($_SESSION['email'])) {
            throw new Exception('電子信箱有誤');
        } elseif (password_verify($password, $_SESSION['password']) === false) {
            throw new Exception('帳號或密碼錯誤');
        } else {
            $_SESSION['logged_in'] = true;
            header('Location: index.php');
        }
    }
} catch (Exception $e) {
    $error = $e->getMessage();
    var_dump($error);
}


?>

<?php require('layouts/header.php') ?>

<form method="POST" action="login.php">
    <div class="container">
        <div class="row justify-content-center" style="padding-top: 50px">
            <div class=" card" style="width: 24rem">
                <div class="card-body">
                    <div class="card-title">
                        <h2 class="d-flex justify-content-center">會員登入</h2>
                    </div>
                    <div class="form-group">
                        <label for="email">電子信箱</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="請輸入電子信箱" autocomplete="off">
                        <?php echo stristr($error, '信箱') ? '<h6 class="text-danger">'.$error.'</h6>':''; ?>
                    </div>
                    <div class="form-group">
                        <label for="password">密碼</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="請輸入密碼">
                        <?php echo stristr($error, '密碼') ? '<h6 class="text-danger">' . $error . '</h6>' : ''; ?>
                    </div>
                    <button class="btn btn-secondary" type="submit" name="submit">登入</button>
                </div>
            </div>
        </div>
    </div>
</form>

<?php require('layouts/footer.php') ?>