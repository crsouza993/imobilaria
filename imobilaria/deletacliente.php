<?php
include('seguranca0.php');
include('conectadb.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $snome = $_POST['snome'];
    $sql = "SELECT COUNT(proprietario_imovel) FROM
     tb_imovel WHERE proprietario_imovel = '$nome $snome'";
    $result = mysqli_query($link,$sql);
    while($tbl=mysqli_fetch_array($result)){
        $total = $tbl[0];
    }
    if($total==0){
    $sql = "DELETE FROM tb_cliente WHERE id_cliente = $id";
    mysqli_query($link, $sql);
    header('Location: listacliente.php');
    }
    else{
        header("Location: deletacliente.php?cliente=$id&msg_erro=Existem imóveis para esse usuário.");
        exit();
    }
}

if (!isset($_GET['cliente'])) header("Location: listacliente.php");
$id = $_GET['cliente'];
if($_SESSION['nivel']==0){
    $id = $_SESSION['id'];
}
$sql = "SELECT nm_cliente, snm_cliente 
    FROM tb_cliente WHERE id_cliente = $id";
$response = mysqli_query($link, $sql);
while($tbl=mysqli_fetch_array($response)){
    $nome = $tbl[0];
    $snome = $tbl[1];
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apaga Cliente</title>
    <link rel="stylesheet" href="estilo.css">
</head>
<body>
<?php
        include('cabecalho.php')
    ?>
    <div id="deleta">
        <h2>Excluir Cliente</h2>
        <form action="deletacliente.php" method="post">
            <p>Deseja excluir o cliente <b><?=$nome?> <?=$snome?></b>?</p>
            <h3 id="msg_erro">
                <?php
                if (isset($_GET['msg_erro'])) echo ($_GET['msg_erro']);
                ?>
            </h3>
            <input type="hidden" name="id" value="<?=$id?>">
            <input type="hidden" name="nome" value="<?=$nome?>">
            <input type="hidden" name="snome" value="<?=$snome?>">
            <input type="submit" value="Sim">
        </form>
        <a href="<?=$_SESSION['nivel']==10?'listacliente.php':'alteracliente.php?cliente=0'?>"><button>Não</button></a>
    </div>
</body>
</html>

