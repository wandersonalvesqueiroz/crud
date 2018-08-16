<?php include("includes/Header.php"); ?>
<?php include("class/Client.php"); ?>

    <div class="container">

        <nav class="navbar navbar-light">
            <h2><i class="fas fa-id-card"></i> Dados do Cliente</h2>
        </nav>

        <div class="card mb-2">
            <div class="card-body">
                <?php
                $clients = new Client();
                $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
                $clientData = $clients->select(
                    "*",
                    "clients",
                    "where id=?",
                    array($id)
                );
                $client = $clientData->fetch(PDO::FETCH_ASSOC);
                ?>
                <h3><?php echo $client['name']; ?></h3>
                <p>CPF: <?php echo $client['cpf']; ?></p>
                <p>E-mail: <?php echo $client['email']; ?></p>
                <p>
                    <?php if ($client['situation'] == 1) {
                        echo '<i class="fas fa-check-circle text-success"></i> Ativo';
                    } else {
                        echo '<i class="fas fa-times-circle text-danger"></i> Inativo';
                    }
                    ?>
                </p>
                <?php
                $clientPhones = $clients->selectPhone(
                    "*",
                    "client_phone",
                    "where id_client=?",
                    array($id)
                );
                if ($clientPhones->rowCount() > 0) {
                    ?>
                    <ul class="list-group">
                        <li class="list-group-item active">Telefone(s):</li>
                        <?php while($phone = $clientPhones->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <li class="list-group-item">
                                <?php echo $phone['phone']; ?>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } ?>
            </div>
        </div>

        <div class="form-group col-12 mb-1">
            <div class="ml-auto">
                <input type="button" onCLick="history.back()" class="btn btn-primary text-light float-right" value="Voltar">
            </div>
        </div>

    </div>
<?php include("includes/Footer.php"); ?>