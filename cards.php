<?php include "partials/header.php" ?>

<?php include "partials/nav.php" ?>

<?php include "options/database.php" ?>

<?php
    $cardQuery = $connection->prepare("select * from cards");
    $cardQuery->execute();
    $cards = $cardQuery->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-3 border">
    <div class="container py-3">
        <h1 class="text-center">Kartlar</h1>

        <div class="container text-center">
            <a href="createCard.php" class="btn btn-success">Kart Ekle</a>
            <a href="updateCard.php" class="btn btn-primary">Kart Güncelle</a>
            <a href="deleteCard.php" class="btn btn-danger">Kart Sil</a>
        </div>
    </div>

    <?php
        if ($_POST) {
            $totalBalance = 0;
            $formIncome = $_POST['formIncome'];
            $formExpense = $_POST['formExpense'];

            $totalBalance += $formIncome;
            $totalBalance -= $formExpense;

            if ($totalBalance > 0) {
                $formQuery = $connection->prepare("update cards set balance = balance + :balance where id= :id");
            } else {
                $formQuery = $connection->prepare("update cards set balance = balance - :balance where id= :id");
            }

            
            $formQuery->execute([':balance' => abs($totalBalance), ':id' => $_POST['cardId']]);

            $formQueryNumber = $formQuery->rowCount();
            
            if ($formQueryNumber > 0) {
                header("refresh:0");
            }
        }
    ?>

    <div class="row g-2 mt-3">
        <?php foreach ($cards as $card): ?>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <h3 class="text-center mt-3">**** **** **** <?= $card['cardLastNumbers'] ?></h3>
        
                    <div class="card-body text-center">
                        <h5 class="card-title"><?= $card['cardName']; ?></h5>

                        <div class="grid">
                            <p class="card-text"><?= $card['cardAction']; ?></p>

                            <h2 class="card-title"><?php
                                echo $card['balance'];

                                switch ($card['currency']) {
                                    case 1:
                                        echo '₺';
                                        break;
                                    case 2:
                                        echo '$';
                                        break;
                                    case 3:
                                        echo '€';
                                        break;
                                    default:
                                        echo '₺';
                                        break;
                                }
                            ?></h2>
                        </div>
                        <button type="button" class="btn btn-outline-primary openModal" data-bs-toggle="modal" data-bs-target="#cardModal<?= $card['id']; ?>">
                            Gelir/Gider
                        </button>
            
                        <div class="modal fade" id="cardModal<?= $card['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel"><?= $card['cardName']; ?> | **** **** **** <?= $card['cardLastNumbers']; ?> | <?php
                                            echo $card['balance'];

                                            switch ($card['currency']) {
                                                case 1:
                                                    echo '₺';
                                                    break;
                                                case 2:
                                                    echo '$';
                                                    break;
                                                case 3:
                                                    echo '€';
                                                    break;
                                                default:
                                                    echo '₺';
                                                    break;
                                            }
                                        ?></h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
            
                                    <div class="modal-body">


                                        <form method="post">
                                            <input type="hidden" name="cardId" value="<?= $card['id']; ?>">

                                            <div class="form-group text-start mb-3">
                                                <label for="formIncome" class="form-label fw-bold text-success">Gelir</label>
                                                <input type="number" name="formIncome" class="form-control" placeholder="Bu karta ait geliri belirtiniz..." value="0">
                                            </div>

                                            <div class="form-group text-start mb-3">
                                                <label for="formExpense" class="form-label fw-bold text-danger">Gider</label>
                                                <input type="number" name="formExpense" class="form-control" placeholder="Bu karta ait gideri belirtiniz..." value="0">
                                            </div>

                                            <div class="form-group mt-3">
                                                <button type="submit" class="btn btn-primary">Kaydet</button>
                                            </div>
                                        </form>
                                    </div>
            
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    const cardModal = document.getElementById('cardModal');
    const myInput = document.getElementById('myInput');

    cardModal.addEventListener('shown.bs.modal', () => {
        myInput.focus();
    });
</script>

<?php include "partials/footer.php" ?>