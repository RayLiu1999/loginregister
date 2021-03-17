<?php require('layouts/header.php') ?>
<div class="container">
    <div class="row justify-content-center">
        <div>
            <h1 class="text-center" style="padding-top: 6rem">會員系統作品</h1><br>
            <?php
            session_start();
            if (isset($_SESSION['logged_in'])) {
                echo '
                    <h1 class="text-center">HELLO, '.$_SESSION['username'].'</h1><br>
                    '.
                    '
                    <p>
                        <a href="./logout.php" class="btn btn-secondary btn-lg" style="width: 18rem">登出</a>
                    </p>
                    ';
            } else {
                echo '
                    <p>
                        <a href="./login.php" class="btn btn-lg btn-primary" style="width: 18rem">登入</a><br>
                    </p>
                    <p>
                        <a href="./signup.php" class="btn btn-lg btn-secondary" style="width: 18rem">註冊</a><br>
                    </p>
                    ';
            }
            ?>
        </div>
    </div>
</div>


<?php require('layouts/footer.php') ?>