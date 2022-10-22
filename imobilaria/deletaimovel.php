<?php
include('seguranca0.php');
include('conectadb.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_SESSION['imovel'];


    $sql = "DELETE FROM tb_imovel WHERE id_imovel = $id";
    mysqli_query($link, $sql);
    header('Location: listaimovel.php');
}

if (!isset($_GET['imovel'])) header("Location: listaimovel.php");
$id = $_GET['imovel'];
if ($_SESSION['nivel'] != 10) {
    $sql = "SELECT proprietario_imovel FROM tb_imovel
 WHERE id_imovel = '$id'";
    $result = mysqli_query($link, $sql);
    while ($tbl = mysqli_fetch_array($result)) {
        $prop = $tbl[0];
    }
    if ($prop != $_SESSION['nome'] . " " . $_SESSION['snome']) {
        header("Location: listaimovel.php?msg_erro=Você não tem permissão para alterar esse imóvel.");
        exit();
    }
}


$_SESSION['imovel'] = $id;
$sql = "SELECT proprietario_imovel 
    FROM tb_imovel WHERE id_imovel = $id";
$response = mysqli_query($link, $sql);
while ($tbl = mysqli_fetch_array($response)) {
    $propri = $tbl[0];
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apaga Imóvel</title>
    <link rel="stylesheet" href="estilo.css">
</head>

<body>
    <?php
    include('cabecalho.php')
    ?>
    <div id="deleta">
        <h2>Excluir Imóvel</h2>
        <form action="deletaimovel.php" method="post">
            <p>Deseja excluir o imóvel <b>código: <?= $id ?></b>
                de propriedade de <b><?= $propri ?></b>?</p>
            <h3 id="msg_erro">
                <?php
                if (isset($_GET['msg_erro'])) echo ($_GET['msg_erro']);
                ?>
            </h3>
            <input type="submit" value="Sim">
        </form>
        <a href="listaimovel.php"><button>Não</button></a>
    </div>
</body>

</html>