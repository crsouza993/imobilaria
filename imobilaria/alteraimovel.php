<?php
include('seguranca0.php');
include('conectadb.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_SESSION['imovel'];
    $prop = $_POST['proprietario'];
    if ($_SESSION['nivel'] != 10) {
        $prop = $_SESSION['nome'] . " " . $_SESSION['snome'];
    }
    $bairro = $_POST['bairro'];
    $dorm = $_POST['dormitorios'];
    $area = $_POST['area'];
    $val = $_POST['valor'];
    $desc = $_POST['descricao'];
    $foto1 = $_POST['foto1'];
    $foto2 = $_POST['foto2'];
    $foto1atual = $_POST['foto1atual'];
    $foto2atual = $_POST['foto2atual'];
    if ($foto1 == '') {
        $foto1 = $foto1atual;
    }
    if ($foto2 == '') {
        $foto2 = $foto2atual;
    }
    $sql = "UPDATE tb_imovel SET desc_imovel = '$desc',
     area_imovel = '$area', dormitorios_imovel = '$dorm',
      valor_imovel = '$val',
     bairro_imovel = '$bairro', proprietario_imovel = '$prop',
     foto1_imovel = '$foto1', foto2_imovel = '$foto2' WHERE id_imovel = $id";

    mysqli_query($link, $sql);
    header("Location: listaimovel.php");
}
$imovel = $_GET['imovel'];
if ($_SESSION['nivel'] != 10) {
    $sql = "SELECT proprietario_imovel FROM tb_imovel
 WHERE id_imovel = '$imovel'";
    $result = mysqli_query($link, $sql);
    while ($tbl = mysqli_fetch_array($result)) {
        $prop = $tbl[0];
    }
    if ($prop != $_SESSION['nome'] . " " . $_SESSION['snome']) {
        header("Location: listaimovel.php?msg_erro=Você não tem permissão para alterar esse imóvel.");
        exit();
    }
}



$sql = "SELECT * FROM tb_imovel WHERE id_imovel = $imovel";
$result = mysqli_query($link, $sql);
while ($tbl = mysqli_fetch_array($result)) {
    $_SESSION['imovel'] = $tbl[0];
    $desc =  $tbl[1];
    $area = $tbl[2];
    $dorm = $tbl[3];
    $val = $tbl[4];
    $bairro = $tbl[5];
    $prop = $tbl[6];
    $foto1 = $tbl[7];
    $foto2 = $tbl[8];
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Imóvel</title>
    <link href="estilo.css" rel="stylesheet">
</head>

<body>
    <?php
    include('cabecalho.php')
    ?>
    <div id="busca">
        <a href="listaimovel.php"><button>Voltar</button></a>
    </div>
    <div id="cadastro">
        <form action="alteraimovel.php" method="post">
            <h2>Cadastro de Imóvel</h2>
            <h3 id="msg_erro">
                <?php
                if (isset($_GET['msg_erro'])) echo ($_GET['msg_erro']);
                ?>
            </h3>
            <p>
                <label>Proprietário:</label>
                <?php
                if ($_SESSION['nivel'] == 10) {
                ?>
                    <select name="proprietario">
                        <?php
                        $sql = "SELECT nm_cliente, snm_cliente FROM tb_cliente";
                        $result = mysqli_query($link, $sql);
                        while ($tbl = mysqli_fetch_array($result)) {
                        ?>
                            <option value="<?= $tbl[0] . ' ' . $tbl[1] ?>" <?= $tbl[0] . ' ' . $tbl[1] == $prop ? 'selected="selected"' : '' ?>>
                                <?= $tbl[0] . ' ' . $tbl[1] ?></option>

                        <?php
                        }
                        ?>
                    </select>
                <?php
                } else {
                ?>
                    <input type="text" name="proprietario" value="<?= $_SESSION['nome'] . " " . $_SESSION['snome'] ?>" disabled>

                <?php
                }
                ?>
            </p>
            <p>
                <label>Bairro:</label>
                <input type="text" name="bairro" value="<?= $bairro ?>" maxlength="15">
            </p>
            <p>
                <label>Dormitórios:</label>
                <input type="number" name="dormitorios" value="<?= $dorm ?>" min="0">
            </p>
            <p>
                <label>Área:</label>
                <input type="number" value="<?= $area ?>" name="area" min="0">
            </p>
            <p>
                <label>Valor:</label>
                <input type="number" name="valor" value="<?= $val ?>" min="0" step="0.01">
            </p>
            <p>
                <label>Descrição:</label>
                <textarea name="descricao" maxlength="250"><?= $desc ?></textarea>
            </p>
            <p>
                <label>Imagem 1:</label>
                <input type="file" name="foto1" accept="image/*">
                <input type="hidden" name="foto1atual" value="<?= $foto1 ?>">
            </p>
            <p>
                <label>Imagem 2:</label>
                <input type="file" name="foto2" accept="image/*">
                <input type="hidden" name="foto2atual" value="<?= $foto2 ?>">
            </p>
            <p>
                <input type="submit" value="Salvar">
            </p>
        </form>

    </div>
    <img id="imgtema" src="img_prog/cadastro.png">
</body>

</html>