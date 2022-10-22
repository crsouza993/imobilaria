<?php
include('cabecalho.php');
include('conectadb.php');
if (!isset($_GET['imovel'])) {
    header('Location:index.php');
    exit();
}
$id = $_GET['imovel'];
$sql = "SELECT * FROM tb_imovel WHERE id_imovel = $id";
$result = mysqli_query($link, $sql);
while ($tbl = mysqli_fetch_array($result)) {
    $desc = $tbl[1];
    $area = $tbl[2];
    $dorm = $tbl[3];
    $valor = $tbl[4];
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
    <title>Imóvel</title>
    <link href="estilo.css" rel="stylesheet">
    <style>
        #index table tr:first-of-type td:first-of-type{
            background-image: url(img/<?=$foto1?>);
            background-size: 360px;
            background-repeat: no-repeat;
            background-position: center;
            width: 360px;
            height: 300px;
        }
        #index table tr:first-of-type td:first-of-type:hover{
            background-image: url(img/<?=$foto2?>);
        }
    </style>
</head>

<body id="index">
<table>
<thead>
  <tr>
    <td rowspan="3"></td>
    <td colspan="3"><?=$desc?></td>
    <td></td>
  </tr>
  <tr>
    <td>Bairro: <?=$bairro?></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td><?=$dorm?> Dormitórios</td>
    <td>Área: <?=$area?> m²</td>
    <td>R$ <?=$valor?></td>
    <td></td>
  </tr>
</thead>
</table>
<div id="prop">
    <p>Entre em contato com o proprietario:</p>
    <br>
    <?php
    if(isset($_SESSION['nome'])){
        $sql = "SELECT email_cliente, cel_cliente FROM tb_cliente
         WHERE CONCAT(nm_cliente, ' ', snm_cliente) = '$prop'";
         
        $result = mysqli_query($link,$sql);
        while($tbl = mysqli_fetch_array($result)){
           
                $emailprop = $tbl[0];
                $foneprop = $tbl[1];
            
        }
        echo("<p><b>Proprietario:</b> $prop <b>Email:</b> $emailprop
         <b>Telefone:</b> $foneprop");
    }
    else{
        echo("<p>Você precisa realizar <b><a href='login.php'>Login</a></b>
        para ver os dados do proprietario.</p>");
    }
    
    ?>
</div>
</body>

</html>