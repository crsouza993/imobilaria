<?php
include('seguranca0.php');
include('conectadb.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $prop = $_POST['proprietario'];
    if($_SESSION['nivel']!=10){
        $prop = $_SESSION['nome'] . " " . $_SESSION['snome'];
    }
    $bairro = $_POST['bairro'];
    $dorm = $_POST['dormitorios'];
    $area = $_POST['area'];
    $valor = $_POST['valor'];
    $desc = $_POST['descricao'];
    $foto1 = $_POST['foto1'];
    $foto2 = $_POST['foto2'];

    $sql = "INSERT INTO tb_imovel (desc_imovel,area_imovel,
    dormitorios_imovel,valor_imovel, bairro_imovel,proprietario_imovel,
    foto1_imovel,foto2_imovel) VALUES ('$desc', $area, $dorm, $valor, 
    '$bairro', '$prop', '$foto1', '$foto2')";
    
    mysqli_query($link,$sql);
    header('Location: listaimovel.php');
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
        <form action="cadastraimovel.php" method="post">

            <h2>Cadastro de Imóvel</h2>
            <h3 id="msg_erro">
                <?php
                if (isset($_GET['msg_erro'])) echo ($_GET['msg_erro']);
                ?>
            </h3>
            <p>
                <label>Proprietário:</label>
                <?php
                if($_SESSION['nivel']==10){
                ?>
                <select name="proprietario">
                    <?php
                        $sql = "SELECT nm_cliente, snm_cliente FROM tb_cliente";
                        $result = mysqli_query($link,$sql);
                        while($tbl=mysqli_fetch_array($result)){
                            ?>
                                <option value="<?= $tbl[0] . ' ' . $tbl[1]?>">
                                 <?= $tbl[0] . ' ' . $tbl[1]?></option>

                            <?php       
                        }

                    
                    ?>
                </select>
                <?php
                }
                else{
                    ?>
                    <input type="text" name="proprietario"
                     value="<?=$_SESSION['nome'] . " " . $_SESSION['snome']?>"
                     disabled>
                     
                    <?php
                }
                ?>
            </p>
            <p>
                <label>Bairro:</label>
                <input type="text" name="bairro" maxlength="15">
            </p>
            <p>
                <label>Dormitórios:</label>
                <input type="number" name="dormitorios" min="0">
            </p>
            <p>
                <label>Área:</label>
                <input type="number" name="area" min="0">
            </p>
            <p>
                <label>Valor:</label>
                <input type="number" name="valor" min="0" step="0.01">
            </p>
            <p>
                <label>Descrição:</label>
                <textarea name="descricao" maxlength="250"></textarea>
            </p>
            <p>
                <label>Imagem 1:</label>
                <input type="file" name="foto1" accept="image/*">
            </p>
            <p>
                <label>Imagem 2:</label>
                <input type="file" name="foto2" accept="image/*">
            </p>
            <p>
                <input type="submit" value="Salvar">
            </p>
        </form>

    </div>
    <img id="imgtema" src="img_prog/cadastro.png">
</body>

</html>