<?php
session_start();
include('conectadb.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $erro = false;
    $nome = $_POST['nome'];
    $snm = $_POST['sobrenome'];
    $cpf = $_POST['cpf'];
    $cpf =  preg_replace("/[^0-9]/", "", $cpf); // deixa apenas numeros
    if (strlen($cpf) != 11) {
        $erro = true;
        header("Location: cliente.php?msg_erro=CPF inválido.");
    }
    $cpf = substr_replace($cpf, '-', 9, 0);
    $cpf = substr_replace($cpf, '.', 6, 0);
    $cpf = substr_replace($cpf, '.', 3, 0);
    $cel = $_POST['celular'];
    $cel = preg_replace("/[^0-9]/", "", $cel);
    if (strlen($cel) != 11) {
        $erro = true;
        header("Location: cliente.php?msg_erro=Celular inválido.");
    }
    $cel = substr_replace($cel, '-', 7, 0);
    $cel = substr_replace($cel, ')', 2, 0);
    $cel = substr_replace($cel, '(', 0, 0);
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $senha = $senha."%gJ78#df67";
    $senha = md5($senha);
    $nivel = $_POST['nivel'];
    if($_SESSION['nivel']!=10){
        $nivel = 0;
    }

    $sql = "SELECT COUNT(id_cliente) FROM tb_cliente
     WHERE email_cliente = '$email'";
    $result = mysqli_query($link, $sql);
    while($tbl = mysqli_fetch_array($result)){
        $total = $tbl[0];
    }
    if($total != 0){
        header('Location: cliente.php?msg_erro=Email já cadastrado');
        exit();
    }



    $sql = "INSERT INTO tb_cliente (nm_cliente, snm_cliente,
     cpf_cliente, cel_cliente, email_cliente, senha_cliente, nivel_cliente)
     VALUES ('$nome', '$snm', '$cpf', '$cel', '$email', '$senha', $nivel)";
    if (!$erro) {
        mysqli_query($link, $sql);
        header("Location: listacliente.php");
    }
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
    </div>
    <div id="cadastro">
        <form action="cadastracliente.php" method="post">

            <h2>Cadastro de Cliente</h2>
            <h3 id="msg_erro">
                <?php
                if (isset($_GET['msg_erro'])) echo ($_GET['msg_erro']);
                ?>
            </h3>
            <p>
                <label>Nome:</label>
                <input type="text" name="nome" maxlength="15">
            </p>
            <p>
                <label>Sobrenome:</label>
                <input type="text" name="sobrenome" maxlength="40">
            </p>
            <p>
                <label>CPF:</label>
                <input type="text" name="cpf" maxlength="14">
            </p>
            <p>
                <label>Celular:</label>
                <input type="text" name="celular" maxlength="14" placeholder="(xx)xxxxx-xxxx">
            </p>
            <p>
                <label>Email:</label>
                <input type="email" name="email" maxlength="30" required>
            </p>
            <p>
                <label>Senha:</label>
                <input type="password" name="senha" maxlength="24" required>
            </p>
            <p>
                <label>Nível:</label>
                <select name="nivel"
                <?php
                    if(!isset($_SESSION['nivel'])|| $_SESSION['nivel']!=10){
                        echo('disabled');
                    }
                ?>          
                >
                    <option value="0">Usuário</option>
                    <option value="10">Administrador</option>
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