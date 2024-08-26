<?php
    include "partials/header.php";
    include "options/database.php";
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-6 mx-auto">
            <div class="card">
                <div class="card-header text-center bg-primary text-white">
                    <h4>KAYIT OL</h4>
                </div>

                <div class="card-body">
                    <?php if ($_POST) {
                        $formUsername = $_POST['username'];
                        $formPassword = $_POST['password'];
                        $formPasswordAgain = $_POST['passwordAgain'];

                        isset($_POST['contract']) ? $formContract = $_POST['contract'] : $formContract = '';
                        
                        if ($formContract != "") {
                            if ($formPassword != "" and $formPasswordAgain != "" and $formUsername != "") {
                                if ($formPassword == $formPasswordAgain) {
                                    $formPassword = md5($formPassword);
                                    $formUsernameQuery = $connection->prepare("select * from users where username = ?");
                                    $formUsernameQuery->execute([$formUsername]);
                                    $formUsernameQueryNumber = $formUsernameQuery->rowCount();

                                    if ($formUsernameQueryNumber > 0) {
                                        echo "<div class='alert alert-danger'>Bu kullanici daha önce kayit olmuş.</div>";
                                    } else {
                                        $registerQuery = $connection->prepare("insert into users (username, password, contract) values(?, ?, ?)");
                                        $registerQuery->execute([$formUsername, $formPassword, $formContract]);
                                        $registerQueryNumber = $registerQuery->rowCount();

                                        if ($registerQueryNumber > 0) {
                                            echo "<div class='alert alert-success'>Kayit Basarili!</div>";
                                            header("refresh:1, url=login.php");
                                        } else {
                                            echo "<div class='alert alert-danger'>Kayit sirasinda bir problem yaşandi. Lütfen tekrar deneyiniz.</div>";
                                        }
                                    }
                                } else {
                                    echo "<div class='alert alert-danger'>Şifreler uyuşmuyor!</div>";
                                }
                            } else {
                                echo "<div class='alert alert-danger'>Lütfen bütün alanlari doldurunuz.</div>";
                            }
                        } else {
                            echo "<div class='alert alert-danger'>Üyelik Sözleşmesini onaylamazdiniz!</div>";
                        }
                    } ?>

                    <form method="post">
                        <div class="form-group">
                            <label for="username" class="form-label fw-bold">Kullanici Adi</label>
                            <input type="text" name="username" class="form-control" placeholder="kullanici adi giriniz...">
                        </div>

                        <div class="form-group mt-3">
                            <label for="password" class="form-label fw-bold">Şifre</label>
                            <input type="password" name="password" class="form-control" placeholder="şifre giriniz...">
                        </div>

                        <div class="form-group mt-3">
                            <label for="passwordAgain" class="form-label fw-bold">Şifre Tekrar</label>
                            <input type="password" name="passwordAgain" class="form-control" placeholder="şifre tekrar giriniz...">
                        </div>

                        <div class="form-group mt-3">
                            <input class="btn-check" id="contract" type="checkbox" name="contract" value="1">
                            <label for="contract" class="btn btn-outline-danger w-100">Üyelik sözleşmesini okudum onayliyorum.</label>
                        </div>

                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary w-100">Kayit Ol</button>
                        </div>

                        <div class="form-group mt-3">
                            <a href="login.php" class="btn btn-outline-warning w-100">Hesabim var</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>