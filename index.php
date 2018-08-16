<?php include("includes/Header.php"); ?>
<?php include("class/Client.php"); ?>

    <div class="container">

        <nav class="navbar navbar-light">
            <h2><i class="fas fa-users"></i> Clientes</h2>
        </nav>

        <div class="row col-12 mb-2 mt-2">
            <a href="insert.php" class="btn btn-success ml-auto">Adicionar</a>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="" method="get" class="form-inline">

                    <div class="form-group col-6 mb-1">
                        <label class="sr-only" for="name">Nome</label>
                        <input type="text" class="form-control col-12" name="name" id="form-name" placeholder="Nome">
                    </div>

                    <div class="form-group col-6 mb-1">
                        <label class="sr-only" for="email">E-mail</label>
                        <input type="email" name="email" class="form-control col-12" id="form-email" placeholder="E-mail">
                    </div>

                    <div class="form-group col-6 mb-1">
                        <label class="sr-only" for="cpf">CPF</label>
                        <input type="text" name="cpf" class="form-control col-12" id="form-cpf" placeholder="CPF" maxlength="14">
                    </div>

                    <div class="form-group col-4 mb-1">
                        <label class="col-sm-4">Situação: </label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="situation" id="inactive" value="0">
                            <label class="form-check-label" for="inactive">Inativo</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="situation" id="active" value="1">
                            <label class="form-check-label" for="active">Ativo</label>
                        </div>
                    </div>

                    <div class="form-group col-2 mb-1">
                        <input type="submit" value="Pesquisar" class="btn btn-sm btn-primary float-right mr-1">
                        <a href="index.php" class="btn btn-sm btn-warning text-light float-right">Limpar</a>
                    </div>
                </form>
            </div>
        </div>

        <table class="table table-bordered list-clients small">
            <thead class="text-center">
            <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>E-mail</th>
                <th>Situação</th>
                <th>Editar</th>
                <th>Excluir</th>
                <th>Ver</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $clients = new Client();
            $name = filter_input(INPUT_GET, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL);
            $cpf = str_replace('-', '', filter_input(INPUT_GET, 'cpf', FILTER_SANITIZE_NUMBER_INT));
            $situation = filter_input(INPUT_GET, 'situation', FILTER_SANITIZE_NUMBER_INT);

            $cond = array();
            $params = array();
            if (!empty($name)) {
                array_push($cond, 'name LIKE ?');
                array_push($params, '%' . $name . '%');
            }
            if (!empty($email)) {
                array_push($cond, 'email LIKE ?');
                array_push($params, '%' . $email . '%');
            }
            if (!empty($cpf)) {
                array_push($cond, 'cpf=?');
                array_push($params, $cpf);
            }
            if (!empty($situation)) {
                array_push($cond, 'situation=?');
                array_push($params, $situation);
            }

            if ($cond) {
                $cond = " WHERE " . implode(" AND ", $cond);
            } else {
                $cond = '';
            }

            $clientsData = $clients->select(
                "*",
                "clients",
                $cond,
                $params
            );
            while ($client = $clientsData->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <tr>
                    <td class="text-center"><?php echo $client['id']; ?></td>
                    <td>
                        <?php echo $client['name']; ?>
                    </td>
                    <td>
                        <?php echo $clients->mask($client['cpf'], '###.###.###-##'); ?>
                    </td>
                    <td>
                        <?php echo $client['email']; ?>
                    </td>
                    <td class="text-center">
                        <?php echo ($client['situation'] == 1) ? 'Ativo' : 'Inativo'; ?>
                    </td>
                    <td class="text-center">
                        <a href="update.php?id=<?php echo $client['id']; ?>" class="btn btn-sm btn-warning text-light">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                    <td class="text-center">
                        <a href="controller/ControllerDeleteClient.php?id=<?php echo $client['id']; ?>" class="removeThis btn btn-sm btn-danger text-light">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>
                    <td class="text-center">
                        <a href="view.php?id=<?php echo $client['id']; ?>" class="btn btn-sm btn-dark text-light">
                            <i class="fas fa-search"></i>
                        </a>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>

    </div>
<?php include("includes/Footer.php"); ?>