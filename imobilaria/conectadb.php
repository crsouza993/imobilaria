<?php
$servidor = "";
$usuario = "admin";
$senha = "";
$banco = "";

$link = mysqli_connect($servidor, $usuario, $senha, $banco)
    or die("Não foi possivel conectar:" . mysqli_error($link));
