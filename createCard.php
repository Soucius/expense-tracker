<?php include "partials/header.php"; ?>

<?php include "partials/nav.php"; ?>

<?php include "options/database.php"; ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-6 mx-auto">
            <div class="card">
                <div class="card-header text-center bg-success text-white">
                    <h4>Kart Ekle</h4>
                </div>

                <div class="card-body">
                    <?php
                        if ($_POST) {
                            $formCardName = $_POST['cardName'];
                            $formCardLastNumbers = $_POST['cardLastNumbers'];
                            $formCardAction = $_POST['cardAction'];
                            $formCurrency = $_POST['currency'];

                            if ($formCardName != "" and $formCardLastNumbers != "" and $formCardAction != "" and $formCurrency != "") {
                                $cardNameQuery = $connection->prepare("insert into cards (cardName, cardLastNumbers, cardAction, currency) values(?, ?, ?, ?)");
                                $cardNameQuery->execute([$formCardName, $formCardLastNumbers, $formCardAction, $formCurrency]);
                                $cardNameQueryNumber = $cardNameQuery->rowCount();

                                if ($cardNameQueryNumber > 0) {
                                    echo "<div class='alert alert-success'>Kart Eklendi.</div>";

                                    header("refresh:1, url=cards.php");
                                }
                            } else {
                                echo "<div class='alert alert-danger'>Lütfen bütün alanlari doldurunuz.</div>";
                            }
                        }
                    ?>

                    <form method="post">
                        <div class="form-group">
                            <label for="cardName" class="form-label fw-bold">Kart Adi</label>
                            <input type="text" name="cardName" class="form-control" placeholder="kart adi giriniz...">
                        </div>

                        <div class="form-group mt-3">
                            <label for="cardLastNumbers" class="form-label fw-bold">Kartin Son 4 Hanesi</label>
                            <input type="text" name="cardLastNumbers" class="form-control" placeholder="kartin son 4 hanesini giriniz...">
                        </div>

                        <div class="form-group mt-3">
                            <label for="cardAction" class="form-label fw-bold">Kart İşlevi</label>
                            <input type="text" name="cardAction" class="form-control" placeholder="kartin işlevini belirtiniz...">
                        </div>

                        <div class="form-group mt-3">
                            <label for="cardAction" class="form-label fw-bold">Kart Para Birimi</label>
                            
                            <select class="form-select" name="currency">
                                <option selected>Para birimini seçiniz...</option>

                                <?php
                                    $currencyQuery = $connection->prepare("select * from currencies");
                                    $currencyQuery->execute();
                                    $currencies = $currencyQuery->fetchAll(PDO::FETCH_ASSOC);

                                    foreach ($currencies as $currency) {
                                        ?>
                                        <option value="<?= $currency['id']; ?>"><?= $currency['currency']; ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                        </div>

                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary w-100">Kart Ekle</button>

                            <a href="cards.php" class="btn btn-outline-danger w-100 mt-3">İptal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "partials/footer.php"; ?>