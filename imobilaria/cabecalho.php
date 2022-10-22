<div id="cabecalho">
    <?php
        if(session_status() == 1) session_start();
        if(isset($_SESSION['nivel'])){
            if($_SESSION['nivel']==0){
                ?>
                <p id="pcabecalho">Bem vindo <b><?=$_SESSION['nome']?></b> |
                 <a href="listaimovel.php">Seus imóveis</a> | 
                 <a href="alteracliente.php?cliente=<?=$_SESSION['id']?>">Seus dados</a> |
                 <a href="logout.php">Sair</a>
            </p>
                <?php
            }
            else{   //nivel 10
                ?>
                <p id="pcabecalho">Bem vindo <b><?=$_SESSION['nome']?></b> |
                 <a href="listaimovel.php">Lista imóveis</a> | 
                 <a href="listacliente.php">Lista clientes</a> |
                 <a href="logout.php">Sair</a>
            </p>
                <?php
            }
        }else{
            ?>
                <p id="pcabecalho">Bem vindo. Faça seu <a href="login.php"
                >Login</a> ou <a href="cadastracliente.php">crie</a> a sua conta.
                 
            </p>
                <?php
        }

?>
    </div>