<?php include "partials/header.php"; ?>

<?php include "partials/nav.php"; ?>

<?php include "options/database.php"; ?>

<?php
    if ($_POST) {
        $ids = $_POST["deleteIds"];
        $partial = implode(", ", $ids);
        
        $deleteQuery = $connection->prepare("delete from cards where id in ($partial)");
        $deleteQuery->execute();
    }
?>

<div class="container mt-5">
    <h2 class="text-center">Kart Sil</h2>

    <form method="post">
        <?php
            $data = $connection->prepare("select * from cards");
            $data->execute();
            $dataNumber = $data->rowCount();
            $datas = $data->fetchAll(PDO::FETCH_ASSOC);
        ?>

        <table class="table table-striped table-hover mt-3">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Kart Adi</th>
                    <th scope="col">Kartin Son 4 Hanesi</th>
                    <th scope="col">Kart İşlevi</th>
                    <th scope="col">Kart Para Birimi</th>
                </tr>
            </thead>
    
            <tbody>
                <?php
                    if ($dataNumber > 0) {
                        foreach ($datas as $data) {
                            ?>
                            <tr>
                                <th scope="row"><input class="form-check-inline" type="checkbox" name="deleteIds[]" value="<?= $data['id'] ?>"></th>

                                <td><?= $data['cardName'] ?></td>
                                <td><?= $data['cardLastNumbers'] ?></td>
                                <td><?= $data['cardAction'] ?></td>
                                <td><?= $data['currency'] ?></td>
                            </tr>
                        <?php
                        }
                    }
                ?>
            </tbody>
        </table>

        <button type="submit" class="btn btn-danger w-100">Sil</button>
    </form>

    <a href="cards.php" class="btn btn-outline-primary w-100 mt-3">İptal</a>
</div>

<?php include "partials/footer.php"; ?>