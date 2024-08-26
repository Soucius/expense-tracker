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
    <h2 class="text-center">Kart Güncelle</h2>

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
                    <th scope="col">ID</th>
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
                                <th scope="row"><?= $data['id'] ?></th>

                                <td contenteditable="true" onfocus="changeBackground(this)" onblur="saveData(this, '<?= $data['id'] ?>', 'cardName')"><?= $data['cardName'] ?></td>

                                <td contenteditable="true" onfocus="changeBackground(this)" onblur="saveData(this, '<?= $data['id'] ?>', 'cardLastNumbers')"><?= $data['cardLastNumbers'] ?></td>

                                <td contenteditable="true" onfocus="changeBackground(this)" onblur="saveData(this, '<?= $data['id'] ?>', 'cardAction')"><?= $data['cardAction'] ?></td>

                                <td contenteditable="true" onfocus="changeBackground(this)" onblur="saveData(this, '<?= $data['id'] ?>', 'currency')"><?= $data['currency'] ?></td>
                            </tr>
                        <?php
                        }
                    }
                ?>
            </tbody>
        </table>
    </form>

    <a href="cards.php" class="btn btn-primary w-100 mt-3">Güncelle</a>
    <a href="cards.php" class="btn btn-outline-danger w-100 mt-3">İptal</a>
</div>

<script>
    function changeBackground(obj) {
        $(obj).removeClass('bg-danger text-white');
        $(obj).addClass('bg-success text-white');
    }

    function saveData(obj, id, column) {
        var card = {
            id: id,
            column: column,
            value: obj.innerHTML
        };

        $.ajax({
            type: "post",
            url: "saveCard.php",
            data: card,
            dataType: "json",
            success: function(data) {
                if ($.trim(data) == "empty") {
                    alert("Boş veri gönderilemez");
                } else if ($.trim(data) == "true") {
                    $(data).removeClass('bg-success text-white');
                    $(data).addClass('bg-danger text-white');
                }
            }
        });
    }
</script>

<?php include "partials/footer.php"; ?>