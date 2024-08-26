    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">Expense Tracker</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">Anasayfa</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="cards.php">Kartlar</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="incomes.php">Gelirler</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="expenses.php">Giderler</a>
                    </li>

                    <?php
                        if (isset($_SESSION["user"])) {
                            ?>
                            <li class="nav-item">
                                <a class="nav-link text-primary" href="account.php"><?= $_SESSION['user'] ?></a>
                            </li>
                            <?php
                        } else {
                            ?>
                            <li class="nav-item">
                                <a class="nav-link text-danger" href="logout.php">Çikiş Yap</a>
                            </li>
                            <?php
                        }
                    ?>
                </ul>
            </div>
        </div>
    </nav>