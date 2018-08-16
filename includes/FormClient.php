<?php
$action = 'insert';
$id = 0;
$name = '';
$email = '';
$cpf = '';
$situation = null;

if (isset($_GET['id'])) {
    $action = 'update';
    $clients = new Client();
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
    $clientData = $clients->select(
        "*",
        "clients",
        "where id=?",
        array($id)
    );
    $client = $clientData->fetch(PDO::FETCH_ASSOC);
    $name = $client['name'];
    $email = $client['email'];
    $cpf = $client['cpf'];
    $situation = $client['situation'];

    $clientPhones = $clients->selectPhone(
        "*",
        "client_phone",
        "where id_client=?",
        array($id)
    );
}

?>
<div class="card">
    <div class="card-body">
        <form name="insertClient" id="insertClient" method="post" action="controller/ControllerInsertClient.php" class="form-inline">

            <input type="hidden" name="action" id="action" value="<?php echo $action; ?>">
            <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">

            <div class="form-group col-12 mb-1">
                <label for="name" class="col-1">Nome:</label>
                <input type="text" name="name" class="form-control col-11" id="name" minlength=5 value="<?php echo $name; ?>" required>
            </div>

            <div class="form-group col-12 mb-1">
                <label for="email" class="col-1">E-mail:</label>
                <input type="email" name="email" class="form-control col-11" id="email" value="<?php echo $email; ?>" required>
            </div>

            <div class="form-group col-6 mb-1">
                <label for="cpf" class="col-2">CPF:</label>
                <input type="text" name="cpf" class="form-control col-10" id="cpf" value="<?php echo $cpf; ?>" required>
            </div>

            <div class="form-group col-6 mb-1">
                <label class="col-sm-4">Situação: </label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="situation" id="inactive" value="0" <?php if($situation !== null && $situation == 0) echo 'checked'; ?>>
                    <label class="form-check-label" for="inactive">Inativo</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="situation" id="active" value="1"  <?php if($situation == 1) echo 'checked'; ?> required>
                    <label class="form-check-label" for="active">Ativo</label>
                </div>
            </div>

            <div id="phone-list" class="list-group col-12">
                <div class="phone-list form-group col-12 mb-1">
                    <label for="phone" class="col-1">Telefone(s):</label>
                    <input type="text" name="phone[]" class="form-control col-4" id="phone" required>
                </div>
            </div>

            <div class="form-group col-12 mb-1">
                <div class="col-5">
                    <a id="add-phone" class="btn btn-primary text-light btn-sm float-right"><i class="fas fa-plus"></i> Telefone</a>
                </div>
            </div>


            <div class="form-group col-12 mb-1">
                <div class="ml-auto">
                    <input type="button" onCLick="history.back()" class="btn btn-danger" value="Cancelar">
                    <input type="submit" value="Salvar" class="btn btn-success">
                </div>
            </div>
        </form>
    </div>
</div>

<?php if (isset($clientPhones) && $clientPhones->rowCount() > 0): ?>
    <table class="table table-bordered list-clients small">
        <thead class="text-center">
        <tr>
            <th>Telefone</th>
            <th>Excluir</th>
        </tr>
        </thead>
        <tbody>
        <?php while($phone = $clientPhones->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <tr>
                <td>
                    <?php echo $phone['phone']; ?>
                </td>
                <td class="text-center">
                    <a href="controller/ControllerDeletePhoneClient.php?id=<?php echo $phone['id']; ?>" class="removeThis btn btn-sm btn-danger text-light">
                        <i class="fas fa-trash-alt"></i>
                    </a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
<?php endif; ?>