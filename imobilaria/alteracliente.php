<?php
include('seguranca0.php');
include('conectadb.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $nome_o = $_POST['nome_orig'];
    $snome = $_POST['sobrenome'];
    $snome_o = $_POST['sobrenome_orig'];
    $cpf = $_POST['cpf'];
    $cpf =  preg_replace("/[^0-9]/", "", $cpf); // deixa apenas numeros
    if (strlen($cpf) != 11) {

        header("Location: alteracliente.php?msg_erro=CPF inválido.&cliente=$id");
        exit();
    }
    $cpf = substr_replace($cpf, '-', 9, 0);
    $cpf = substr_replace($cpf, '.', 6, 0);
    $cpf = substr_replace($cpf, '.', 3, 0);
    $cel = $_POST['celular'];
    $cel = preg_replace("/[^0-9]/", "", $cel);
    if (strlen($cel) != 11) {

        header("Location: alteracliente.php?msg_erro=Celular inválido.&cliente=$id");
        exit();
    }
    $cel = substr_replace($cel, '-', 7, 0);
    $cel = substr_replace($cel, ')', 2, 0);
    $cel = substr_replace($cel, '(', 0, 0);
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $nivel = $_POST['nivel'];
    if ($_SESSION['nivel'] == 0) {
        $nivel = 0;
    }

    $sql = "SELECT email_cliente, senha_cliente FROM tb_cliente WHERE id_cliente = '$id'";
    $result = mysqli_query($link, $sql);
    while ($tbl = mysqli_fetch_array($result)) {
        $email_o = $tbl[0];
        $senha_o = $tbl[1];
    }
    if($senha!=$senha_o){
        $senha = md5($senha."%gJ78#df67");
    }



    if ($email != $email_o) {
        $sql = "SELECT COUNT(id_cliente) FROM tb_cliente
    WHERE email_cliente = '$email'";
        $result = mysqli_query($link, $sql);
        while ($tbl = mysqli_fetch_array($result)) {
            $total = $tbl[0];
        }
        if ($total != 0) {
            header("Location: alteracliente.php?msg_erro=Email já cadastrado&cliente=$id");
            exit();
        }
    }

    if ($nome != $nome_o || $snome != $snome_o) {
        $sql = "UPDATE tb_imovel SET proprietario_imovel = '$nome $snome' 
        WHERE proprietario_imovel = '$nome_o $snome_o'";
        mysqli_query($link, $sql);
    }




    $sql = "UPDATE tb_cliente SET nm_cliente = '$nome',
     snm_cliente = '$snome', cpf_cliente = '$cpf', cel_cliente = '$cel',
     email_cliente = '$email', senha_cliente = '$senha',
     nivel_cliente = $nivel WHERE id_cliente = $id";

    mysqli_query($link, $sql);
    if ($_SESSION['nivel'] == 10) {
        header("Location: listacliente.php");
        exit();
    } else {
        header("Location: login.php?msg_erro=Você deve refazer seu login.");
        exit();
    }
}
if (!isset($_GET['cliente'])) header("Location: listacliente.php");

$cliente = $_GET['cliente'];
if ($_SESSION['nivel'] != 10) {
    $cliente = $_SESSION['id'];
}
$sql = "SELECT * FROM tb_cliente WHERE id_cliente = $cliente";
$result = mysqli_query($link, $sql);
while ($tbl = mysqli_fetch_array($result)) {
    $id = $tbl[0];
    $nome = $tbl[1];
    $snome = $tbl[2];
    $cpf = $tbl[3];
    $cel = $tbl[4];
    $email = $tbl[5];
    $senha = $tbl[6];
    $nivel  = $tbl[7];
}


?>




<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Cliente</title>
    <link href="estilo.css" rel="stylesheet">
</head>

<body>
    <?php
    include('cabecalho.php')
    ?>
    <div id="busca">
        <a href="listacliente.php"><button>Voltar</button></a>
        <?php
        if ($_SESSION['nivel'] != 10) {
        ?>
            <a href="deletacliente.php?cliente=<?= $_SESSION['id'] ?>"><button>Excluir Conta</button></a>
        <?php
        }
        ?>
    </div>
    <div id="cadastro">
        <form action="alteracliente.php" method="post">
            <input type="hidden" name="id" value="<?= $id ?>">
            <h2>Cadastro de Cliente</h2>
            <h3 id="msg_erro">
                <?php
                if (isset($_GET['msg_erro'])) echo ($_GET['msg_erro']);
                ?>
            </h3>
            <p>
                <label>Nome:</label>
                <input type="text" name="nome" value="<?= $nome ?>" maxlength="15">
                <input type="hidden" name="nome_orig" value="<?= $nome ?>">
            </p>
            <p>
                <label>Sobrenome:</label>
                <input type="text" name="sobrenome" value="<?= $snome ?>" maxlength="40">
                <input type="hidden" name="sobrenome_orig" value="<?= $snome ?>">
            </p>
            <p>
                <label>CPF:</label>
                <input type="text" name="cpf" value="<?= $cpf ?>" maxlength="14">
            </p>
            <p>
                <label>Celular:</label>
                <input type="text" name="celular" value="<?= $cel ?>" maxlength="14" placeholder="(xx)xxxxx-xxxx">
            </p>
            <p>
                <label>Email:</label>
                <input type="email" name="email" value="<?= $email ?>" maxlength="30" required>
            </p>
            <p>
                <label>Senha:</label>
                <input type="password" name="senha" value="<?= $senha ?>" maxlength="24" required>
            </p>
            <p>
                <label>Nível:</label>
                <select name="nivel" <?= $_SESSION['nivel'] == 0 ? 'disabled' : '' ?>>
                    <option value="0" <?= $nivel == 0 ? 'selected="selected"' : '' ?>>Usuário</option>
                    <option value="10" <?= $nivel == 10 ? 'selected="selected"' : '' ?>>Administrador</option>
                </select>
            </p>
            <p>
                <input type="submit" value="Salvar">
            </p>
        </form>

    </div>
    <img id="imgtema" src="img_prog/cadastro.png">
</body>

</html>