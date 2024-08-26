<?php
    include "partials/header.php";
    include "options/database.php";
    session_start();
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-6 mx-auto">
            <div class="card">
                <div class="card-header text-center bg-success text-white">
                    <h4>Giriş Yap</h4>
                </div>

                <div class="card-body">
                    <?php
                        if ($_POST) {
                            $formUsername = $_POST['username'];
                            $formPassword = md5($_POST['password']);

                            if ($formUsername != "" and $formPassword != "") {
                                $usernameQuery = $connection->prepare("select * from users where username = ? and password = ?");
                                $usernameQuery->execute([$formUsername, $formPassword]);
                                $usernameQueryNumber = $usernameQuery->rowCount();

                                if ($usernameQueryNumber > 0) {
                                    $_SESSION["user"] = $formUsername;

                                    echo "<div class='alert alert-success'>Giriş başarili.</div>";

                                    header("refresh:1, url=index.php");
                                } else {
                                    echo "<div class='alert alert-danger'>Girdiğiniz bilgilere ait kullanici bulunamadi.</div>";
                                }
                            } else {
                                echo "<div class='alert alert-danger'>Lütfen bütün alanlari doldurunuz.</div>";
                            }
                        }
                    ?>

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
                            <a href="#" class="text-danger float-end mb-3 small">Şifremi Unuttum</a>
                        </div>

                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary w-100">Giriş Yap</button>
                        </div>

                        <div class="form-group mt-3">
                            <a href="register.php" class="btn btn-outline-warning w-100">Hesabim yok</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>